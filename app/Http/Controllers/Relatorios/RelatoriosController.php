<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 11/02/2019
 * Time: 17:31
 */

namespace App\Http\Controllers\Relatorios;


use App\Http\Controllers\BaseController;
use App\Jobs\ProcessAnalyticReport;
use App\Models\AnalyticsReport;
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
            if (!$analyticsReport = AnalyticsReport::where('filename', $basename)->first()) {
                $analyticsReport = new AnalyticsReport(
                    [
                        'filename' => $basename,
                        'args' => json_encode($request->all()),
                        'user_id' => Auth::id(),
                        'hash' => $hash
                    ]
                );
                $analyticsReport->save();
                ProcessAnalyticReport::dispatch($hash);
            }
            return $this->sendResponse([], 'Processo de criação de relatório iniciado! ' .
                'Utilize a aba "Relatórios disponíveis" para verificar o estado atual.');
        }

        $response['url'] = route('relatorios.analytic-export-download', [$hash]);
        return $this->sendResponse($response, 'Arquivo já está pronto para download. URL enviada.');
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