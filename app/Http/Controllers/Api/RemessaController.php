<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 10/12/2018
 * Time: 23:37
 */

namespace app\Http\Controllers\Api;


use App\Http\Controllers\BaseController;
use App\Models\Docs;
use App\Models\DocsHistory;
use App\Models\Files;
use App\Models\Profile;
use App\Models\Seal;
use App\Models\SealGroup;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class RemessaController extends BaseController
{

    /**
     * @param $user_id
     * @return mixed
     */
    public function getCapaLoteUnregistered(Request $request)
    {
        $user_id = (int)$request->get("_u");
        if ($user_id < 1 || !$user = Users::find($user_id)) {
            $this->sendError('Ocorreu um erro ao validar o acesso ao conteúdo.', 400);
        }
        $query = Files::query()
            ->select([
                "files.constante as constante", "files.movimento as movimento",
                "docs.content as content", "docs.status as status", "docs.from_agency",
                "docs.to_agency", "docs.updated_at", "docs.created_at",
                "docs.id", "origin.nome as agencia_origin", "destin.nome as agencia_destin"
            ])
            ->join("docs", "files.id", "=", "docs.file_id")
            ->leftJoin("agencia as origin", "docs.from_agency", "=", "origin.codigo")
            ->leftJoin("agencia as destin", "docs.to_agency", "=", "destin.codigo")
            ->whereIn('docs.status', ['pendente']);

        if ($user->profile != Profile::ADMIN) {
            $juncao = $user->juncao;
            $query->where([
                ['docs.from_agency', '=', sprintf("%04d", $juncao)]
            ]);
        }

        return Datatables::of($query)
            ->filterColumn('constante', function ($query, $keyword) {
                $query->where('files.constante', '=', $keyword);
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
            ->addColumn('action', function ($doc) {
                return '<input type="checkbox" name="lote[]" class="form-control form-control-sm m-input input-doc" ' .
                'value="' . $doc->id . '">';
            })
            ->editColumn('from_agency', function ($doc) {
                if ($doc->agencia_origin != null) {
                    return '<a href="javascript:void(0);" title="' . $doc->agencia_origin . '" data-toggle="tooltip">' .
                    $doc->from_agency . '</a>';
                } else {
                    return $doc->from_agency;
                }
            })
            ->editColumn('to_agency', function ($doc) {
                if ($doc->agencia_destin != null) {
                    return '<a href="javascript:void(0);" title="' . $doc->agencia_destin . '" data-toggle="tooltip">' .
                    $doc->to_agency . '</a>';
                } else {
                    return $doc->to_agency;
                }
            })
            ->editColumn('constante', function ($doc) {
                return __('labels.' . $doc->constante);
            })
            ->editColumn('updated_at', function ($doc) {
                return $doc->updated_at ? with(new Carbon($doc->updated_at))->format('d/m/Y H:i') : '';
            })
            ->editColumn('status', function ($doc) {
                return $doc->status ? __('status.' . $doc->status) : '-';
            })
            ->editColumn('created_at', function ($doc) {
                return $doc->created_at ? with(new Carbon($doc->created_at))->format('d/m/Y') : '';
            })
            ->editColumn('movimento', function ($doc) {
                return $doc->movimento ? with(new Carbon($doc->movimento))->format('d/m/Y') : '';
            })
            ->addColumn('view', function ($doc) use ($user) {
                return '<a data-toggle="modal" href="#capaLoteHistoryModal" data-dochistory-id="' . $doc->id .
                '" title="Histórico" class="btn btn-sm btn-outline-primary m-btn m-btn--icon m-btn--icon-only">' .
                '<i class="fas fa-eye"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function registrarRemessa(Request $request)
    {
        $in_transaction = false;
        try {
            if (!$user = Users::find($request->get('user'))) {
                throw new \Exception('Ocorreu um erro ao verificar permissão');
            }

            $params = $request->all();

            // Iniciando transaction
            DB::beginTransaction();
            $in_transaction = true;
            if (!$seal = Seal::where('content', $params['lacre'])->first()) {
                $seal = new Seal();
                $seal->user_id = $user->id;
                $seal->content = $params['lacre'];
                $seal->save();
            }
            $regs = 0;
            foreach ($params['doc'] as $doc_id) {
                if (!$sealGroup = SealGroup::where('doc_id', $doc_id)->first()) {
                    $sealGroup = new SealGroup();
                    $sealGroup->seal_id = $seal->id;
                    $sealGroup->doc_id = $doc_id;
                    $sealGroup->save();
                }
                if ($doc = Docs::find($doc_id)) {
                    $doc->status = Docs::STATE_SENT;
                    $doc->save();
                    $docHistory = new DocsHistory(
                        [
                            'doc_id' => $doc_id,
                            'description' => DocsHistory::STATE_SENT,
                            'user_id' => $user->id,
                        ]
                    );

                    $docHistory->save();
                    $regs++;
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            if ($in_transaction == true) {
                DB::rollback();
            }
            return response()->json($e->getMessage(), 400);
        }
        return response()->json(
            sprintf('%s Remessa%s Registrada%2$s', ($regs > 0 ? $regs : 'Nenhuma'), $regs > 1 ? 's' : ''), 200
        );
    }
}