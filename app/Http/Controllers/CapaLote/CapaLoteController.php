<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 10/12/2018
 * Time: 23:37
 */

namespace app\Http\Controllers\CapaLote;


use App\Http\Controllers\BaseController;
use App\Models\Agencia;
use App\Models\Audit;
use App\Models\Docs;
use App\Models\DocsHistory;
use App\Models\Files;
use App\Models\Menu;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;

use Validator;
use PDF;

class CapaLoteController extends BaseController
{

    private $doc_types = [1 => 'CHEQUE DEVOLVIDO', 'CHEQUE CUSTODIA', 'CHEQUE PAGO', 'CHEQUE COMPENSADO'];

    public function index()
    {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('capalote.index', compact('menus'));
    }

    public function contingencia(Request $request)
    {
        if (Auth::user()->profile == 'OPERADOR') {
            $request->session()->flash('alert-danger', 'Recurso não encontrado');
            return redirect(route('home'));
        }
        $menu = new Menu();
        $menus = $menu->menu();
        $doc_types = $this->doc_types;
        $automatic_types = array_keys($doc_types);
        array_shift($automatic_types);
        // Tipo de Documento presente dentro da Capa de Lote
        return view('capalote.contingencia', compact('menus', 'doc_types', 'automatic_types'));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function _new(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'origem' => 'nullable|digits:4|not_in:0000',
            'destino' => 'required|digits:4|not_in:0000',
            'tipo_documento' => 'required|between:1,4',
            'qtdedocs' => 'required|gt:0|lt:100',
        ]);

        $validator->after(function ($validator) use ($request) {
            // Check the user Juncao
            if (Auth::user()->profile == 'AGÊNCIA') {
                if (trim($request->get('origem')) != Auth::user()->juncao) {
                    $validator->errors()->add('origem', 'Há uma divergência na Agência de Origem!');
                }
            }
            // Check the Agencia Destino against Tipo Documento
            $automatic_types = array_keys($this->doc_types);
            array_shift($automatic_types);
            if (in_array($request->get('tipo_documento'), $automatic_types) &&
                trim($request->get('destino', '4510')) != '4510'
            ) {
                $validator->errors()->add('destino', 'Há uma divergência na Agência de Destino!');
            }
        });

        if ($validator->fails()) {
            $request->session()->flash('alert-danger', 'Erros encontrados. Verifique as informações e tente novamente!');
            return redirect(route('capalote.contingencia'))
                ->withErrors($validator)
                ->withInput();
        }
        // Form valid

        // Criaando a nova Capa de Lote

        $capalote = sprintf('%04d%04d%05d',
            trim($request->get('origem')),
            trim($request->get('destino', '4510')),
            date('zy')
        );
        /**
         * @doc Toda Capa de Lote no sistema está vinculada a um arquivo e então
         */
        $oFile = new Files(
            [
                'name' => 'RA237' . date('dm.y') . '1',
                'total' => 1,
                'constante' => 'RA',
                'file_hash' => hash('crc32b', 'RA237' . date('dm.y') . '1' . date('YmdHis')),
                'codigo' => '237',
                'movimento' => new \DateTime(),
                'sequencial' => 1,
                'user_id' => Auth::user()->id,
            ]
        );
        if ($oFile->save()) {
            if (!Docs::where([['content', 'like', $capalote], ['file_id', '=', $oFile->id]])->first()) {
                $oDoc = new Docs(
                    [
                        'file_id' => $oFile->id,
                        'content' => $capalote,
                        'from_agency' => trim($request->get('origem')),
                        'to_agency' => trim($request->get('destino', '4510')),
                    ]
                );
                $oDoc->status = 'contingencia';
                $oDoc->user_id = Auth::user()->id;

                if ($oDoc->save()) {
                    $oHistory = new DocsHistory(
                        [
                            'doc_id' => $oDoc->id,
                            'description' => "Contingenciamento",
                            'user_id' => Auth::user()->id,
                        ]
                    );
                    if (!$oHistory->save()) {
                        $oDoc->delete();
                        $oFile->delete();
                        $request->session()->flash('alert-danger', 'Erro ao criar entrada de historico. ' .
                            'Tente novamente. Se o problema persistir informe ao Administrador do Sistema');
                    }
                } else {
                    $oFile->delete();
                    $request->session()->flash('alert-danger', 'Não foi possível criar a Capa de Lote neste momento. ' .
                        'Tente novamente mais tarde. Se o problema persistir informe ao Administrador do Sistema');

                }
            }
            Audit::create([
                'description' => sprintf('Capa de Lote [%s] criada - Contingenciamento', $oDoc->content),
                'user_id' => Auth::id()
            ]);
            $request->session()->flash('alert-success', 'Capa de Lote criada com Sucesso!');
        }
        return redirect(route('capalote.contingencia'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        $capalote = preg_replace('#\D#', '', $request->get('capalote'));
        if (strlen($capalote) == 13) {
            if (!$doc = Docs::where('content', $capalote)->first()) {
                $request->session()->flash('alert-warning', 'Capa de Lote inexistente!');
                return redirect(route('capalote.buscar'));
            }
        } else {
            $request->session()->flash('alert-danger', 'Código de Capa de Lote inválida!');
            return redirect(route('capalote.buscar'));
        }
        $menu = new Menu();
        $menus = $menu->menu();
        return view('capalote.show', compact('menus', 'doc'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function find()
    {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('capalote.find', compact('menus'));
    }

    /**
     * @param Request $request
     * @param $doc_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showPDF(Request $request, array $doc_id)
    {
        $menu = new Menu();
        $menus = $menu->menu();
        if ($doc = Docs::find($doc_id)) {
            $doc->destino = Agencia::where("codigo", "=", $doc->to_agency)->first();
            $doc->origem = Agencia::where("codigo", "=", $doc->from_agency)->first();
            return view('capalote.show', compact('menus', 'doc'));
        }
        $request->session()->flash('alert-danger', 'Erro ao recuperar informações. ' .
            'Tente novamente. Se o problema persistir informe ao Administrador do Sistema');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function showPDFMultiple(Request $request)
    {
        $docs_id = $request->get('capalote');
        $docs = [];
        foreach ($docs_id as $doc_id) {
            if ($doc = Docs::find($doc_id)) {
                (($doc->destino = $doc->destin) ||
                    $doc->destino = new Agencia(['codigo' => $doc->to_agency, 'nome' => 'Agência sem cadastro']));
                (($doc->origem = $doc->origin) ||
                    $doc->origem = new Agencia(['codigo' => $doc->from_agency, 'nome' => 'Agência sem cadastro']));
                $docs[] = $doc;
            }
        }
        $pdf = PDF::loadView('capalote.pdf', compact('docs'));
        return $pdf->stream(sprintf('capalote%s.pdf', date('Ymd_Hi')));
    }

}