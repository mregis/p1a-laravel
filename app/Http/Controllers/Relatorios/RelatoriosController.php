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
        // Criando um nome unico para cada requisicao
        $hash = hash('crc32b', serialize($request->all()));
        $basename = sprintf('analitico_%s.xlsx', $hash);
        $basepath = config('filesystems.disks.local.root');
        $export_dir = $basepath . '/excel_exports';
        // Garantindo a existencia do diretorio
        !is_dir($export_dir) && mkdir($export_dir, 0775, true) && ($export_dir = $basepath);

        if(!is_file($export_dir . '/' . $basename)) {
            $query = Docs::query()
                ->select([
                    "files.constante as constante", "files.movimento as movimento",
                    "files.name as filename", "docs.id",
                    "docs.content", "docs.status", "docs.from_agency",
                    "docs.to_agency", "docs.updated_at", "docs.created_at",
                    "origin.nome as origin", "destin.nome as destin",
                    "docs.user_id",
                    "users.name as username", "users.profile",
                    "users.juncao", "agencia.nome as agencia_usuario",
                    "users.unidade",
                ])
                ->join("files", "docs.file_id", "=", "files.id")
                ->join("users", "docs.user_id", "=", "users.id")
                ->leftJoin("agencia", "users.juncao", "=", "agencia.codigo")
                ->leftJoin("agencia as origin", "docs.from_agency", "=", "origin.codigo")
                ->leftJoin("agencia as destin", "docs.to_agency", "=", "destin.codigo");


            if ($request->get('di') != null) {
                $di = new \DateTime($request->get('di'));
            } else {
                $di = new \DateTime("-90 days");
            }
            $query->where('files.movimento', '>=', $di);

            if ($request->get('df') != null) {
                $df = new \DateTime($request->get('df'));
                $query->where('files.movimento', '<=', $df);
            }

            $orders = array();
            foreach ((array)$request->get('order') as $index => $order) {
                $orders[] = sprintf("%s %s", $order['column'], $order['dir']);
            }
            count($orders) > 0 && $query->orderByRaw(implode(", ", $orders));

            if ($search = request('search[value]')) {
                $query->orWhere(function ($query) use ($search) {
                    $query->where([
                        ['content', '=', $search],
                        ['filename', '=', $search],
                        ['constante', '=', $search],
                        ['from_agency', '=', $search],
                        ['to_agency', '=', $search],
                        ['profile', '=', $search],
                    ]);
                });
            }

            $export = new DocsExport($query); // Criando a planilha
            $filename = str_replace($basepath, '', $export_dir) . '/' . $basename;
            $export->store($filename); // Salvando em disco para usar como cache
        }
        return response()->download($export_dir . '/' . $basename, $basename); // Lendo do disco
    }
}