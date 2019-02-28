<?php

namespace App\Jobs;

use App\Exports\DocsExport;
use App\Models\AnalyticsReport;
use App\Models\DocsHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use PHPUnit\Runner\Exception;

class ProcessAnalyticReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $analyticsReport;
    protected $hash;

    /**
     * Create a new job instance.
     *
     * @param AnalyticsReport $params
     * @return void
     */
    public function __construct($hash)
    {
        $this->hash = $hash;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($analyticsReport = AnalyticsReport::where('hash', $this->hash)->first()) {

            try {
                $params = json_decode($analyticsReport->args, 1);
                $di = new \DateTime(isset($params['di']) ? $params['di'] : '-1 month');
                $df = new \DateTime(isset($params['df']) ? $params['df'] : 'now');

                // Criando um nome unico para cada requisicao
                $basename = $analyticsReport->filename;
                $basepath = config('filesystems.disks.local.root');
                $export_dir = $basepath . '/excel_exports';
                // Garantindo a existencia do diretorio
                !is_dir($export_dir) && mkdir($export_dir, 0775, true) && ($export_dir = $basepath);

                $analyticsReport->state = AnalyticsReport::STATE_RUNING;
                $analyticsReport->save();

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
                        ['files.movimento', '>=', $di->format('Y-m-d')],
                        ['files.movimento', '<=', $df->format('Y-m-d')],
                    ]);

                $_orders = (isset($params['order']) ? (array)$params['order'] : []);
                $orders = [];
                foreach ($_orders as $index => $order) {
                    (isset($order['column'], $order['dir'])) &&
                    $orders[] = sprintf("%s %s", $order['column'] + 1, $order['dir']);
                }
                count($orders) > 0 && $query->orderByRaw(implode(", ", $orders));

                $search_value = '';
                (isset($params['search'])) && ($search = $params['search']) &&
                isset($search['value']) && ($search_value = $search['value']);

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
                            ->orWhere('user_agency.nome', '=', $search_value);
                    });
                }
                $export = new DocsExport($query); // Criando a planilha
                $hash = str_replace($basepath, '', $export_dir) . '/' . $basename;
                $export->store($hash, '', \Maatwebsite\Excel\Excel::XLSX); // Salvando em disco para usar como cache
                $analyticsReport->state = AnalyticsReport::STATE_COMPLETE;
                $analyticsReport->save();
            } catch (Exception $e) {
                $analyticsReport->state = AnalyticsReport::STATE_ERROR;
                $analyticsReport->save();
            }
        }
    }

}
