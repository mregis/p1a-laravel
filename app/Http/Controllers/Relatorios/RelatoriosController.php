<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 11/02/2019
 * Time: 17:31
 */

namespace App\Http\Controllers\Relatorios;


use App\Exports\DocsExport;
use App\Http\Controllers\BaseController;
use App\Models\Docs;
use App\Models\DocsHistory;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class RelatoriosController extends BaseController
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function analytic()
    {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('report.analytic', compact('menus'));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportAnalytic(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->profile, ['ADMINISTRADOR', 'DEPARTAMENTO']) ) {
            throw new AccessDeniedHttpException('Você não tem permissão para acessar esse recurso.');
        }

        $di = new \DateTime($request->get('di', '-1 month'));
        $df = new \DateTime($request->get('df'));

        if ($df->diff($di)->days > 31) { // Periodo de mais de 1 mes
            return $this->sendError("Período inválido! Máximo de 1 mês.", 400);
        }
        // Criando um nome unico para cada requisicao
        $hash = hash('crc32b', serialize($request->all()));
        $basename = sprintf('analitico_%s.xlsx', $hash);
        $basepath = config('filesystems.disks.local.root');
        $export_dir = $basepath . '/excel_exports';
        // Garantindo a existencia do diretorio
        !is_dir($export_dir) && mkdir($export_dir, 0775, true) && ($export_dir = $basepath);

        if(!is_file($export_dir . '/' . $basename)) {
            set_time_limit(0);
            ini_set('max_execution_time', 0); // no limit for maximum execution time

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
                ])
                ->join("docs", "docs_history.doc_id", "=", "docs.id")
                ->join("files", "docs.file_id", "=", "files.id")
                ->join("users", "docs_history.user_id", "=", "users.id")
                ->leftJoin("agencia as origin", "docs.from_agency", "=", "origin.codigo")
                ->leftJoin("agencia as destin", "docs.to_agency", "=", "destin.codigo")
                ->leftJoin("agencia as user_agency", "users.juncao", "=", "user_agency.codigo")
                ->where([
                    ['files.movimento', '<=', $df->format('Y-m-d')],
                    ['files.movimento', '>=', $di->format('Y-m-d')],
                ])
            ;

            $orders = array();
            foreach ((array)$request->get('order') as $index => $order) {
                $orders[] = sprintf("%s %s", $order['column']+1, $order['dir']);
            }
            count($orders) > 0 && $query->orderByRaw(implode(", ", $orders));

            $search_value = '';
            ($search = $request->get('search')) && isset($search['value']) && ($search_value = $search['value']);
            if ($search_value != '') {
                $query->where(function ($query) use ($search_value) {
                    $query->orWhere('docs.content', '=', $search_value)
                        ->orWhere('files.constante', '=', $search_value)
                        ->orWhere('docs.from_agency', '=', $search_value)
                        ->orWhere('origin.nome', '=', $search_value)
                        ->orWhere('docs.to_agency', '=', $search_value)
                        ->orWhere('destin.nome', '=', $search_value)
                        ->orWhere('users.name', '=', $search_value)
                        ->orWhere('users.profile', '=', $search_value)
                        ->orWhere('users.juncao', '=', $search_value)
                        ->orWhere('users.unidade', '=', $search_value)
                        ->orWhere('docs_history.description', '=', $search_value)
                        ->orWhere('user_agency.codigo', '=', $search_value)
                        ->orWhere('user_agency.nome', '=', $search_value)
                    ;
                });
            }

            $export = new DocsExport($query); // Criando a planilha
            $filename = str_replace($basepath, '', $export_dir) . '/' . $basename;
            $export->store($filename); // Salvando em disco para usar como cache
        }

        $response['url'] = route('relatorios.analytic-export-download', [$hash]);
        return $this->sendResponse($response, '');
    }


    /**
     * @param $code
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadAnalyticReport($code)
    {
        $basename = sprintf('analitico_%s.xlsx', $code);
        $basepath = config('filesystems.disks.local.root');
        $export_dir = $basepath . '/excel_exports';
        $filename = $export_dir . '/' . $basename;
        if (!is_file($filename)) {
            return $this->sendError("Requisição inválida!", 404);
        }

        return response()->download($filename, $basename);
    }
}