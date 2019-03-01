<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 10/12/2018
 * Time: 23:37
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\BaseController;
use App\Models\AnalyticsReport;
use App\Models\Users;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Yajra\DataTables\Facades\DataTables;


class AnalyticsReportController extends BaseController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function _list(Request $request)
    {
        $user_id = (int)$request->get('_u');

        try {
            if (!$user = Users::find($user_id)) {
                throw new \Exception('Erro ao verificar permissões.');
            }

            if (!in_array($user->profile, ['ADMINISTRADOR', 'DEPARTAMENTO'])) {
                throw new AccessDeniedHttpException('Você não tem permissão para acessar esse recurso.');
            }

            $datatable = DataTables::of(AnalyticsReport::query())

                ->addColumn('action', function ($report) {
                    $res = '- - -';
                    if ($report->state == AnalyticsReport::STATE_COMPLETE) {
                        $res = sprintf('<a href="%s" data-toggle="tooltip" ' .
                                ' class="btn btn-sm btn-outline-primary" title="Fazer o download do relatório">' .
                                '<i class="fas fa-download"></i></a>',
                                route('relatorios.analytic-export-download', [$report->hash])) .
                            sprintf('<a href="javascript: deleteReport(%d)" data-toggle="tooltip" title="Excluir relatório" ' .
                                'class="btn btn-sm btn-outline-danger"><i class="fas fa-times"></i></a>',
                                $report->id)
                        ;
                    }
                    return $res;
                })
                ->addColumn('username', function($report) {
                    return $report->user->name;
                })
                ->editColumn('state', function ($report) {
                    return __('labels.' . $report->state);
                })

                ->editColumn('created_at', function ($report) {
                    return $report->created_at ? with(new Carbon($report->created_at))->format('d/m/Y H:i') : '';
                })

                ->addColumn('params', function ($report){
                    $args = json_decode($report->args, 1);
                    $res = sprintf('Período: <b>%s</b> a <b>%s</b>', $args['di'], $args['df']);
                    if (isset($args['search']['value']) && $args['search']['value'] != '') {
                        $res .= ' Filtro: <b>' . $args['search']['value'] . '</b>';
                    }
                    return $res;
                })

                ->escapeColumns([]);

            return $datatable->make(true);

        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
    }

    /**
     * @param $id
     */
    public function _delete(Request $request, $id)
    {
        $user_id = (int)$request->get('_u');

        try {
            if (!$user = Users::find($user_id)) {
                throw new \Exception('Erro ao verificar permissões.');
            }

            if (!in_array($user->profile, ['ADMINISTRADOR', 'DEPARTAMENTO'])) {
                throw new AccessDeniedHttpException('Você não tem permissão para acessar esse recurso.');
            }

            if (!$analyticReport = AnalyticsReport::find($id)) {
                throw new NotFoundHttpException('Recurso não encontrado');
            }

            $basename = $analyticReport->filename;
            $basepath = config('filesystems.disks.local.root');
            $export_dir = $basepath . '/excel_exports';
            $filename = $export_dir . '/' . $basename;
            if (!is_file($filename)) {
                return $this->sendError("Requisição inválida!", 404);
            }
            unlink($filename);
            $analyticReport->delete();
            return $this->sendResponse([], "Relatório excluído com sucesso!");
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
    }
}