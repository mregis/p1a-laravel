<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 10/12/2018
 * Time: 23:37
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\BaseController;
use App\Models\DocsHistory;
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
        $id = (int)$request->get('id');
        try {
            if ($id < 1) {
                return $this->sendResponse([], "Capa de Lote inexistente", 200);
            }
            $query = DocsHistory::query()
                ->select([
                    "docs_history.id",
                    "docs_history.description as history_description",
                    "docs_history.created_at",
                    "docs.content",
                    "docs.from_agency",
                    "docs.to_agency",
                    "docs.created_at as doc_created_at",
                    "docs.id as doc_id",
                    "files.movimento",
                    "files.constante",
                    "files.name as filename",
                    "origin.codigo as cod_agencia_origem",
                    "origin.nome as nome_agencia_origem",
                    "destin.codigo as cod_agencia_destino",
                    "destin.nome as nome_agencia_destino",
                    "users.name as history_user_name",
                    "users.juncao as juncao_usuario_criador",
                    "users.profile as history_user_profile",
                    "user_agency.codigo as codigo_juncao_criador",
                    "user_agency.nome as nome_juncao_criador",
                    "users.unidade as unidade_criador",
                ])
                ->join("docs", "docs_history.doc_id", "=", "docs.id")
                ->join("files", "docs.file_id", "=", "files.id")
                ->join("users", "docs_history.user_id", "=", "users.id")
                ->leftJoin("agencia as origin", "docs.from_agency", "=", "origin.codigo")
                ->leftJoin("agencia as destin", "docs.to_agency", "=", "destin.codigo")
                ->leftJoin("agencia as user_agency", "users.juncao", "=", "user_agency.codigo")
                ->where("docs.id", $id)
            ;

            $datatable = DataTables::of($query)
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
                ->editColumn('origem', function ($doc) {
                    return $doc->cod_agencia_origem . ': ' . $doc->nome_agencia_origem;
                })
                ->editColumn('destino', function ($doc) {
                    return $doc->cod_agencia_destino . ': ' . $doc->nome_agencia_destino;
                })
                ->addColumn('history_local', function ($doc) {
                    return $doc->nome_juncao_criador == null ? $doc->unidade_criador : (string)$doc->nome_juncao_criador;
                })
                ->escapeColumns([]);

            return $datatable->make(true);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 400);
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
                    "files.name as filename",
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
                ])
                ->join("docs", "docs_history.doc_id", "=", "docs.id")
                ->join("files", "docs.file_id", "=", "files.id")
                ->join("users", "docs_history.user_id", "=", "users.id")
                ->leftJoin("agencia as origin", "docs.from_agency", "=", "origin.codigo")
                ->leftJoin("agencia as destin", "docs.to_agency", "=", "destin.codigo")
                ->leftJoin("agencia as user_agency", "users.juncao", "=", "user_agency.codigo")

            ;

            $datatable = DataTables::of($query)
                ->filter(function ($query) use ($df, $di) {
                    $query->where([
                        ['files.movimento', '<=', $df],
                        ['files.movimento', '>=', $di],
                    ]);
                }, true)
                ->filterColumn('constante', function ($query, $keyword) {
                    $query->where('files.constante', '=', $keyword);
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
                ->filterColumn('nome_agencia_origem', function ($query, $keyword) {
                    $query->where('origin.nome', '=', $keyword);
                })
                ->filterColumn('to_agency', function ($query, $keyword) {
                    $query->where('docs.to_agency', '=', $keyword);
                })
                ->filterColumn('nome_agencia_destino', function ($query, $keyword) {
                    $query->where('destin.nome', '=', $keyword);
                })
                ->filterColumn('nome_usuario_criador', function ($query, $keyword) {
                    $query->where('users.name', '=', $keyword);
                })
                ->filterColumn('perfil_usuario_criador', function ($query, $keyword) {
                    $query->where('users.profile', '=', $keyword);
                })
                ->filterColumn('local', function ($query, $keyword) {
                    $query->whereOr([
                        ['users.unidade', '=', $keyword],
                        ['users.juncao', '=', $keyword],
                        ['user_agency.nome', '=', $keyword],
                    ]);
                })
                ->filterColumn('status', function ($query, $keyword) {
                    $query->where('docs.status', '=', $keyword);
                })
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