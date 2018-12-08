<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Users;
use App\Models\Audit;
use App\Models\Files;
use App\Models\Docs;
use App\Models\DocsHistory;
use App\Models\Seal;
use App\Models\SealGroup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Auth;
class ReceiveController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('receive.receive', compact('menus'));
    }

    public function fileList(Request $request, $user_id) {

        if (!$user = Users::find($user_id)) {
            return response()->json('Ocorreu um erro ao validar o acesso ao conteúdo.', 400);
        }
        $query = Files::query()
            ->select(
                [
                    "files.id", "files.name", "files.total", "files.created_at",
                    DB::raw('count(pendentes.id) as pendentes'),
                ] )
            ->leftJoin("docs as pendentes",
                function ($join) use ($user) {
                    $join->on("files.id", '=', "pendentes.file_id")
                        ->where("pendentes.status", "=", "pendente");
                    if ($user->profile != 'ADMINISTRADOR') {
                        $join->where("pendentes.content", "like", sprintf("%04d", $user->juncao) . '%');
                    }
                }
            )
            ->groupBy(["files.id", "files.name", "files.total", "files.created_at"])
        ;

        if($user->profile != 'ADMINISTRADOR') {
            $query->join("docs", "files.id", "=", "docs.file_id")
            ->where("docs.content", "like", sprintf("%04d", $user->juncao) . '%');
        }

        return Datatables::of($query)
            ->filterColumn('pendentes', function($query, $keyword) {
                $query->where('pendentes', '=', $keyword);
            })
            ->addColumn('view', function($file) {
                return '<a href="/receber/' . $file->id .'" title="Exibir detalhes" ' .
                'class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only">' .
                '<i class="fas fa-eye"></a>';
            })
            ->editColumn('created_at', function ($file) {
                return $file->created_at? with(new Carbon($file->created_at))->format('d/m/Y') : '';
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function list(Request $request, $id)
    {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('receive.receive_list', compact('menus', 'id'));
    }

    public function arquivos(Request $request)
    {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('upload.upload_list', compact('menus'));
    }
    public function arquivo(Request $request, $id)
    {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('upload.upload_edit', compact('menus', 'id'));
    }

    public function removearquivo(Request $request,$id)
    {
        $menu = new Menu();
        $menus = $menu->menu();
//        return view('upload.upload_list', compact('menus'));
    }

    public function docs(Request $request, $id , $profile , $juncao = false)
    {

        if (!$file = Files::find($id)) {
            return response()->json('Não foi possível recuperar as informações requisitadas', 400);
        }

        $query = Docs::query()
            ->select("docs.*", "files.constante as constante")
            ->join("files", "docs.file_id", "=", "files.id")
            ->where("files.id", "=", $id)
            ->where(function ($query) {
                $query->whereNotIn('status', ['recebido'])
                    ->orWhere('status', '=', null);
                }
            )
        ;

        if ($profile != 'ADMINISTRADOR') {
            $query->where(
                function ($query) use ($juncao) {
                    $query->orWhere(function ($query) use ($juncao) {
                        $query->where([
                            ['files.constante', '=', 'DM'],
                            ['content', 'like', sprintf("%04d", $juncao) . '%']
                        ]);
                    })
                        ->orWhere(function ($query) use ($juncao) {
                            $query->where([
                                ['files.constante', '<>', 'DM'],
                                ['content', 'like', '%' . sprintf("%04d", $juncao)]
                            ]);
                        });
                });
        }

        return Datatables::of($query)
            ->addColumn('action', function ($doc) {
                return '<input style="float:left;width:20px;margin: 6px 0 0 0;" ' .
                    'type="checkbox" name="lote[]" class="form-control m-input input-doc" ' .
                    'value="'. $doc->id.'">';
            })
            ->addColumn('origem', function ($doc) use ($file) {
                $doc->content = trim($doc->content);
                return ($file->constante == "DM" ? "DM" : substr($doc->content, 0, 4));
            })
            ->addColumn('destino', function ($doc) use ($file) {
                $doc->content = trim($doc->content);
                return ($file->constante == "DM" ? substr($doc->content, 0, 4) : substr($doc->content, -4, 4));
            })
            ->addColumn('status', function($doc) {
                return $doc->status ? $doc->status : '-';
            })
            ->editColumn('created_at', function ($doc) {
                return $doc->created_at ? with(new Carbon($doc->created_at))->format('d/m/Y H:i') : '';
            })
            ->editColumn('updated_at', function ($doc) {
                return $doc->created_at ? with(new Carbon($doc->created_at))->format('d/m/Y H:i') : '';
            })
            ->make(true);
    }

    public function destroy(Request $request, $id)
    {
        die('aki');
    }

    public function check(Request $request, $id)
    {
        $file = Docs::where('id', $id)->first();

        if (is_null($file)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $file->status = 'concluido';
        $file->user_id = Auth::user()->id;

        $file->save();
        return $this->sendResponse($file->toArray(), 'Informação atualizada com sucesso');
    }

    public function registrar(Request $request)
    {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('receive.receive_register', compact('menus'));
    }
    public function register(Request $request)
    {
        if (!$user = Users::find($request->get('user'))) {
            return response()->json('Ocorreu um erro ao verificar permissão', 404);
        }

        $params = $request->all();

        $regs = 0;
        foreach ($params['doc'] as &$doc) {
            if ($docs = Docs::find($doc)) {
                $docs->status = 'recebido';
                $docs->user_id = $user->id;
                $docs->save();
                $docsHistory = new DocsHistory();
                $docsHistory->doc_id = $doc;
                $docsHistory->description = "Capa recebida";
                $docsHistory->user_id = $params['user'];
                $docsHistory->save();
                $regs++;
            }
        }
        return response()->json(
            sprintf('%s Capa%s Recebida%2$s', ($regs > 0 ? $regs : 'Nenhuma'), $regs > 0 ? 's':''), 200
        );
    }
    public function registeroperador(Request $request)
    {
        $params = $request->all();

        if($seal = Seal::where('content',$params['lacre'])->first()){
                $id = $seal->id;
        }else{
		$seal = new Seal();
		$seal->user_id = $params['user'];
		$seal->content = $params['lacre'];
		$seal->save();
		$id = $seal->id;
        }
        foreach($params['doc'] as &$d){
            $doc = Docs::where('content','like','%'.trim($d).'%')->first();
	    if($doc->id){
                $doc->status = 'em trânsito';
                $doc->user_id = $params['user'];
                $doc->save();

                $docsHistory = new DocsHistory();
                $docsHistory->doc_id = $doc->id;
                $docsHistory->description = "Capa em trânsito";
                $docsHistory->user_id = $params['user'];
                $docsHistory->save();                        
                if($sealGroup = SealGroup::where('doc_id',$doc->id)->first()){
                    $idGroup = $sealGroup->id;
                } else {
                    $sealGroup = new SealGroup();
                    $sealGroup->seal_id = $id;
                    $sealGroup->doc_id = $doc->id;
                    $sealGroup->save();
                    $idGroup = $sealGroup->id;
                }
            }
        }
        return $this->sendResponse($idGroup, 'Informação atualizada com sucesso');
    }
    public function operador(Request $request)
    {
        $menu = new Menu();
        $menus = $menu->menu();

	$files = Files::all();
	foreach($files as &$file){
		$docs = Docs::where('file_id', $file->id)->get();
		$pendentes = 0;
		foreach($docs as &$d){
			if($d->status == 'pendente'){
				$pendentes++;
			}
		}
		$file->pendentes = $pendentes;
	}
        return view('receive.operador', compact('menus','files'));
    }

    public function docListingIndex() {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('receive.receive_doclist', compact('menus', 'id'));
    }

    public function doclisting(Request $request, $profile , $juncao = false)
    {
        $query = Docs::query()
            ->select("docs.*", "files.constante as constante")
            ->join("files", "docs.file_id", "=", "files.id")
        ;
        if ($profile != 'ADMINISTRADOR') {
                $query
                    ->orWhere(function ($query) use ($juncao) {
                        $query->where([
                            ['files.constante', '=', 'DM'],
                            ['content', 'like', sprintf("%04d", $juncao) . '%']
                        ])
                            ->where(function ($query) {
                                $query->whereNotIn('status', ['recebido'])
                                    ->orWhere('status', '=', null);
                            });
                    })
                    ->orWhere(function ($query) use ($juncao) {
                        $query->where([
                            ['files.constante', '<>', 'DM'],
                            ['content', 'like', '%' . sprintf("%04d", $juncao)]
                        ])
                            ->where(function ($query) {
                                $query->whereNotIn('status', ['recebido'])
                                    ->orWhere('status', '=', null);
                            });
                    });

        }
        return Datatables::of($query)
            ->filterColumn('constante', function($query, $keyword) {
                $query->where('files.constante', '=', $keyword);
            })
            ->addColumn('action', function ($doc) {
                return '<input style="float:left;width:20px;margin: 6px 0 0 0;" ' .
                'type="checkbox" name="lote[]" class="form-control m-input input-doc" ' .
                'value="'. $doc->id.'">';
            })
            ->addColumn('view', function($doc) {
                return '<a data-toggle="modal" href="#capaLoteHistoryModal" onclick="getHistory(' . $doc->id . ')" ' .
                'title="Histórico" class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only"><i class="fas fa-eye">' .
                '</a>';
            })

            ->editColumn('constante', function ($doc) {
                $doc->content = trim($doc->content);
                return ($doc->constante == "DM" ? "Devolução Matriz" : "Devolução Agência");
            })
            ->addColumn('origem', function ($doc) {
                $doc->content = trim($doc->content);
                return ($doc->constante == "DM" ? "<b>4510</b>" : substr($doc->content, 0, 4));
            })
            ->addColumn('destino', function ($doc) {
                $doc->content = trim($doc->content);
                return ($doc->constante == "DM" ? substr($doc->content, 0, 4) : substr($doc->content, -4, 4));
            })
            ->addColumn('status', function($doc) {
                return $doc->status ? $doc->status : '-';
            })
            ->editColumn('updated_at', function ($doc) {
                return $doc->updated_at ? with(new Carbon($doc->updated_at))->format('d/m/Y H:i') : '';
            })
            ->editColumn('created_at', function ($doc) {
                return $doc->created_at? with(new Carbon($doc->created_at))->format('d/m/Y') : '';
            })
            ->escapeColumns([])
            ->make(true);
    }

}
