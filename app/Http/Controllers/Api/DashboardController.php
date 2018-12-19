<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use App\Models\Files;
use App\Models\Docs;
use DataTables;
use Illuminate\Support\Facades\DB;

class DashboardController extends BaseController
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function toAgencyReport(Request $request, $user_id)
    {
        if (!$user = Users::find($user_id)) {
            return $this->response()->json("Erro ao verificar permissões", 400);
        }

        $query = Docs::query()
            ->select([
                    DB::raw("SUM(CASE WHEN docs.status = 'pendente' THEN 1 ELSE 0 END) as pendente"),
                    DB::raw("SUM(CASE WHEN docs.status IN ('concluido', 'enviado', 'recebido') THEN 1 ELSE 0 END) as concluido"),
                    DB::raw("COUNT(*) as total"),
                    "files.movimento as movimento"
                    ]
                )
            ->where("files.constante", "=", "DA")
            ->groupBy(["files.movimento"])
            ->join("files", "docs.file_id", "=", "files.id");
        if ($user->juncao != null) {
            $query->where("docs.from_agency", "=", $user->juncao);
        }
        return DataTables::of($query)
            ->editColumn('movimento', function($doc) {
                return with(new Carbon($doc->movimento))->format('d/m/Y');
            })
            ->make(true);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function fromAgencyReport(Request $request, $user_id)
    {
        if (!$user = Users::find($user_id)) {
            return $this->response()->json("Erro ao verificar permissões", 400);
        }

        $query = Docs::query()
            ->select([
                    DB::raw("SUM(CASE WHEN docs.status = 'pendente' THEN 1 ELSE 0 END) as pendente"),
                    DB::raw("SUM(CASE WHEN docs.status IN ('concluido', 'enviado', 'recebido') THEN 1 ELSE 0 END) as concluido"),
                    DB::raw("COUNT(*) as total"),
                    "files.movimento as movimento"
                ]
            )
            ->where("files.constante", "=", "DA")
            ->groupBy(["files.movimento"])
            ->join("files", "docs.file_id", "=", "files.id");
        if ($user->juncao != null) {
            $query->where("docs.to_agency", "=", $user->juncao);
        }
        return DataTables::of($query)
            ->editColumn('movimento', function($doc) {
                return with(new Carbon($doc->movimento))->format('d/m/Y');
            })
            ->make(true);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function returnAgencyReport(Request $request, $user_id)
    {
        if (!$user = Users::find($user_id)) {
            return $this->response()->json("Erro ao verificar permissões", 400);
        }

        $query = Docs::query()
            ->select([
                    DB::raw("SUM(CASE WHEN docs.status = 'pendente' THEN 1 ELSE 0 END) as pendente"),
                    DB::raw("SUM(CASE WHEN docs.status IN ('concluido', 'enviado', 'recebido') THEN 1 ELSE 0 END) as concluido"),
                    DB::raw("COUNT(*) as total"),
                    "files.movimento as movimento"
                ]
            )
            ->where("files.constante", "=", "DM")
            ->groupBy(["files.movimento"])
            ->join("files", "docs.file_id", "=", "files.id");
        if ($user->juncao != null) {
            $query->where("docs.from_agency", "=", $user->juncao);
        }
        return DataTables::of($query)
            ->editColumn('movimento', function($doc) {
                return with(new Carbon($doc->movimento))->format('d/m/Y');
            })
            ->make(true);
    }
}
