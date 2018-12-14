<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 10/12/2018
 * Time: 23:37
 */

namespace app\Http\Controllers\CapaLote;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCapaLote;
use App\Models\Agencia;
use App\Models\Docs;
use App\Models\DocsHistory;
use App\Models\Files;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Validation\Validator;

use Validator;

class CapaLoteController extends Controller
{

    private $doc_types = [1 => 'CHEQUE DEVOLVIDO', 'CHEQUE CUSTODIA', 'CHEQUE PAGO', 'CHEQUE COMPENSADO'];

    public function index(Request $request) {
        $menu = new Menu();
        $menus = $menu->menu();
        $doc_types = $this->doc_types;
        $automatic_types = array_keys($doc_types);
        array_shift($automatic_types);
        // Tipo de Documento presente dentro da Capa de Lote
        return view('capalote.index', compact('menus', 'doc_types', 'automatic_types'));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function _new(Request $request) {

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
                trim($request->get('destino', '4510')) != '4510') {
                $validator->errors()->add('destino', 'Há uma divergência na Agência de Destino!');
            }
        });

        if ($validator->fails()) {
            $request->session()->flash('alert-danger', 'Erros encontrados. Verifique as informações e tente novamente!');
            return redirect(route('capalote.index'))
                ->withErrors($validator)
                ->withInput();
        }
        // Form valid

        // Criaando a nova Capa de Lote

        $capalote = sprintf('%04d%04d%5d',
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
                'dia' => date('d'),
                'mes' => date('m'),
                'ano' => date('Y'),
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
            $request->session()->flash('alert-success', 'Capa de Lote criada com Sucesso!');
        }
        return redirect(route('capalote.index'));
    }

    public function show(){
        $menu = new Menu();
        $menus = $menu->menu();
        return view('capalote.show', compact('menus'));
    }

    /**
     * @param Request $request
     * @param $docs_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showPDF(Request $request, $doc_id) {
        $menu = new Menu();
        $menus = $menu->menu();

        $doc = Docs::find($doc_id);
        $doc->destino = Agencia::where("codigo", "=", $doc->to_agency)->first();
        $doc->origem = Agencia::where("codigo", "=", $doc->from_agency)->first();
        return view('capalote.show', compact('menus', 'doc'));
    }
}