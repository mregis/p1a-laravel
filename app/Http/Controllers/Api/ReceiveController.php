<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Users;
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

    /**
     * @param $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function fileList($user_id) {

        if (!$user = Users::find($user_id)) {
            return response()->json('Ocorreu um erro ao validar o acesso ao conteúdo.', 400);
        }
        $query = Files::query()
            ->select(
                [
                    "files.id", "files.name", "files.created_at", "files.movimento",
                    DB::raw("sum(CASE WHEN docs.status = 'pendentes' THEN 1 ELSE 0 END) as pendentes"),
                    DB::raw('count(DISTINCT docs.id) as total'),
                ])
            ->join("docs",
                function ($join) use ($user) {
                    $join->on("files.id", '=', "docs.file_id");
                    if (!in_array($user->profile, ['ADMINISTRADOR', 'DEPARTAMENTO'])) {
                        $join->where("docs.to_agency", "=", sprintf("%04d", $user->juncao));
                    }
                }
            )
            ->groupBy(["files.id", "files.name", "files.created_at", "files.movimento"])
        ;

        return Datatables::of($query)
            ->addColumn('view', function($file) {
                return '<a href="/receber/' . $file->id .'" title="Exibir detalhes" ' .
                'class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only">' .
                '<i class="fas fa-eye"></a>';
            })
            ->editColumn('created_at', function ($file) {
                return $file->created_at? with(new Carbon($file->created_at))->format('d/m/Y') : '';
            })
            ->editColumn('movimento', function ($file) {
                return with(new Carbon($file->movimento))->format('d/m/Y');
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

    /**
     * @param $id
     * @param $profile
     * @param bool|false $juncao
     * @return \Illuminate\Http\JsonResponse
     */
    public function docs($id , $profile , $juncao = false)
    {
        if (!$file = Files::find($id)) {
            return response()->json('Não foi possível recuperar as informações requisitadas', 400);
        }

        $query = Docs::query()
            ->select("docs.*", "files.constante as constante")
            ->join("files", "docs.file_id", "=", "files.id")
            ->where("files.id", "=", $id)
            ->where(function ($query) {
                $query->whereNotIn('docs.status', ['recebido'])
                    ->orWhere('docs.status', '=', null);
                }
            );

        if ($profile != 'ADMINISTRADOR') {
            $query->where(
                function ($query) use ($juncao) {
                    $query->orWhere(function ($query) use ($juncao) {
                        $query->where([
                            ['files.constante', '=', 'DM'],
                            ['docs.to_agency', '=', sprintf("%04d", $juncao)]
                        ]);
                    })
                        ->orWhere(function ($query) use ($juncao) {
                            $query->where([
                                ['files.constante', '<>', 'DM'],
                                ['docs.from_agency', '=', sprintf("%04d", $juncao)]
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
        $user_id = $params['user'];
        if (!$user = Users::find($user_id)) {
            return response()->json('Erro ao verificar permissões.', 400);
        }
        if (!in_array($user->profile, ['OPERADOR', 'ADMINISTRADOR'])) {
            return response()->json('Você não tem permissão para executar esta operação.', 400);
        }

        if (!$seal = Seal::where('content', $params['lacre'])->first()) {
            $seal = new Seal();
            $seal->user_id = $user_id;
            $seal->content = $params['lacre'];
            $seal->save();
        }
        $notfound = [];
        foreach ($params['doc'] as $capaLote) {
            if ($doc = Docs::where('content', 'like', '%' . trim($capaLote) . '%')->first()) {
                $doc->status = 'em trânsito';
                $doc->user_id = $user_id;
                $doc->save();

                $docsHistory = new DocsHistory();
                $docsHistory->doc_id = $doc->id;
                $docsHistory->description = "Capa em trânsito";
                $docsHistory->user_id = $user_id;
                $docsHistory->save();
                if (!$sealGroup = SealGroup::where('doc_id', $doc->id)->first()) {
                    $sealGroup = new SealGroup();
                    $sealGroup->seal_id = $seal->id;
                    $sealGroup->doc_id = $doc->id;
                    $sealGroup->save();
                }
            } else {
                $notfound[] = $capaLote;
            }
        }
        ($msg = "Informação atualizada com sucesso!") &&
        (count($notfound) > 0) && ($msg .= "\n\nAtenção!\n" .
        "As seguintes Capas de Lote não foram encontradas:\n[" . implode("]-[", $notfound) ."]");

        return response()->json($msg, 200);
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

    /**
     * @param $profile
     * @param null|int $juncao
     * @return mixed
     */
    public function doclisting($profile , $juncao = null)
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
                            ['docs.from_agency', '=', sprintf("%04d", $juncao)]
                        ])
                            ->where(function ($query) {
                                $query->whereNotIn('status', ['recebido'])
                                    ->orWhere('status', '=', null);
                            });
                    })
                    ->orWhere(function ($query) use ($juncao) {
                        $query->where([
                            ['files.constante', '<>', 'DM'],
                            ['docs.to_agency', '=', sprintf("%04d", $juncao)]
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
            ->addColumn('origin', function ($doc) {
                if ($doc->origin != null) {
                    return '<a href="javascript:void();" title="' . $doc->origin . '" data-toggle="tooltip" data-trigger="click">' .
                    $doc->from_agency . '</a>';
                } else {
                    return $doc->from_agency;
                }
            })
            ->addColumn('destin', function ($doc) {
                if ($doc->destin != null) {
                    return '<a href="javascript:void();" title="' . $doc->destin . '" data-toggle="tooltip" data-trigger="click">' .
                    $doc->to_agency . '</a>';
                } else {
                    return $doc->to_agency;
                }
            })
            ->editColumn('constante', function ($doc) {
                $doc->content = trim($doc->content);
                return ($doc->constante == "DM" ? "Devolução Matriz" : "Devolução Agência");
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

    public function checkCapaLote(Request $request) {
        $capaLote = $request->get('capaLote');
        if ($doc = Docs::where('content', '=', $capaLote)->first()) {
            return response()->json('Capa de Lote encontrada', 200);
        } else {
            return response()->json( sprintf('Capa de Lote inexistente [%s]', $capaLote), 400);
        }
    }

}
