<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 10/12/2018
 * Time: 23:37
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\BaseController;
use App\Models\Agencia;
use App\Models\Docs;
use App\Models\DocsHistory;
use App\Models\Seal;
use App\Models\Users;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Yajra\DataTables\Facades\DataTables;


class DocsHistoryController extends BaseController
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function getDocsHistory(Request $request)
    {
        $id = $request->get('id');
        try {

            if (!$doc = Docs::find($id)) {
                throw new \Exception('Capa de Lote inexistente');
            }
            if (!$file = $doc->file) {
                throw new \Exception('Arquivo não encontrado');
            }
            if (!$user = $doc->user) {
                throw new Exception('Erro ao buscar informações de usuário de capa de lote');
            }

            if ($doc->origin == null) {
                $doc->origin()->associate(new Agencia(['codigo' => $doc->from_agency, 'nome' => 'Agência sem cadastro']));
            }

            if ($doc->destin == null) {
                $doc->destin()->associate(new Agencia(['codigo' => $doc->to_agency, 'nome' => 'Agência sem cadastro']));
            }

            foreach ($doc->history as $h) {
                if (!$user = $h->user) {
                    throw new Exception('Erro ao buscar informações de usuário de histórico');
                }
                $h->local = ($h->user->agencia == null ? $h->user->unidade : (string)$h->user->agencia);
                $h->description = __('status.' . $h->description);
            }

            return response()->json($doc, 200);

        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 400);
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function getDocsHistoryAnalyticReport(Request $request)
    {
        $user_id = (int)$request->get('_u');

        try {
            if (!$user = Users::find($user_id)) {
                throw new \Exception('Erro ao verificar permissões.');
            }

            if (!in_array($user->profile, ['ADMINISTRADOR', 'DEPARTAMENTO'])) {
                throw new AccessDeniedHttpException('Você não tem permissão para acessar esse recurso.');
            }
            set_time_limit(0);
            ini_set('max_execution_time', 0); // no limit for maximum execution time

            $di = new \DateTime($request->get('di', '-30 days'));
            $df = new \DateTime($request->get('df', 'now'));

            $query = DocsHistory::query()
                ->select([
                    "docs_history.id",
                    "docs_history.description as descricao_historico",
                    "docs_history.created_at",
                    "docs.content",
                    "docs.from_agency",
                    "docs.to_agency",
                    "docs.id as doc_id",
                    "files.movimento",
                    "files.constante",
                    "origin.codigo as cod_agencia_origem",
                    "origin.nome as nome_agencia_origem",
                    "destin.codigo as cod_agencia_destino",
                    "destin.nome as nome_agencia_destino",
                    "users.name as nome_usuario_criador",
                    "users.juncao as juncao_usuario_criador",
                    "users.profile as perfil_usuario_criador",
                    "user_agency.codigo as codigo_juncao_criador",
                    "user_agency.nome as nome_juncao_criador",
                    "users.unidade as unidade_criador",
//                    DB::raw("array_agg(seal.content) as seals"),
                ])
                ->join("docs", "docs_history.doc_id", "=", "docs.id")
                ->join("files", "docs.file_id", "=", "files.id")
                ->join("users", "docs_history.user_id", "=", "users.id")
                ->leftJoin("agencia as origin", "docs.from_agency", "=", "origin.codigo")
                ->leftJoin("agencia as destin", "docs.to_agency", "=", "destin.codigo")
                ->leftJoin("agencia as user_agency", "users.juncao", "=", "user_agency.codigo")
//                ->leftJoin("seal_group", "docs.id", "=", "seal_group.doc_id")
//                ->leftJoin("seal", "seal_group.seal_id", "=", "seal.id")
            ->where([
                    ['files.movimento', '<=', $df],
                    ['files.movimento', '>=', $di],
                ])
            ;

            $query_seal = Seal::query()
                ->select(['seal.content'])
                ->join("seal_group", "seal.id", "=", "seal_group.seal_id")
            ;

            $datatable = DataTables::of($query)
/* *
                ->filter(function ($query) {
                    if (request()->has('di')) {
                        if (request('di') != null) {
                            $di = new \DateTime(request('di'));
                            $query->where('files.movimento', '>=', $di);
                        }
                    }

                    if (request()->has('df')) {
                        if (request('df') != null) {
                            $df = new \DateTime(request('df'));
                            $query->where('files.movimento', '<=', $df);
                        }
                    }
                }, true)
/* *
                ->filterColumn('constante', function ($query, $keyword) {
                    $query->where('files.constante', '=', $keyword);
                })
                ->filterColumn('movimento', function ($query, $keyword) {
                    ;
                })
                ->filterColumn('filename', function ($query, $keyword) {
                    $query->where('files.name', '=', $keyword);
                })
                ->filterColumn('content', function ($query, $keyword) {
                    $query->where('docs.content', '=', $keyword);
                })
                ->filterColumn('from_agency', function ($query, $keyword) {
                    $query->where('docs.from_agency', '=', $keyword);
                })
                ->filterColumn('to_agency', function ($query, $keyword) {
                    $query->where('docs.to_agency', '=', $keyword);
                })
                ->filterColumn('status', function ($query, $keyword) {
                    $query->where('docs.status', '=', $keyword);
                })
/* *
                ->addColumn('seals', function ($doc) use($query_seal) {
                    return '';
                    $seals = [];
                    $q = $query_seal->where("seal_group.doc_id", "=", $doc->doc_id);
                    foreach ($q->get() as $seal) {
                        $seals[] = '<span class="badge badge-pills badge-primary">' . $seal->content . '</span>';
                    }
                    return implode(", ", $seals);
                })
/* */
                ->addColumn('local', function ($doc) {
                    return ($doc->juncao_usuario_criador != null ?
                        $doc->juncao_usuario_criador . ': ' . $doc->nome_juncao_criador :
                        $doc->unidade_criador);
                })
                ->editColumn('constante', function ($doc) {
                    return __('labels.' . $doc->constante);
                })
                ->editColumn('movimento', function ($doc) {
                    return with(new Carbon($doc->movimento))->format('d/m/Y');
                })
                ->editColumn('created_at', function ($doc) {
                    return $doc->created_at ? with(new Carbon($doc->created_at))->format('d/m/Y H:i') : '';
                })
                ->editColumn('status', function ($doc) {
                    return __('status.' . $doc->descricao_historico);
                })
                ->escapeColumns([]);

            return $datatable->make(true);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
    }
}