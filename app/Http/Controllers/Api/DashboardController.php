<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Docs;
use Auth;
use DataTables;
use DB;

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


    public function report(Request $request, $user_id)
    {
        if (!$user = Users::find($user_id)) {
            return $this->response()->json("Erro ao verificar permissões", 400);
        }
        $query = Docs::query()
            ->select([
                DB::raw("SUM(CASE WHEN docs.status = 'pendente' AND fa.constante='DA' THEN 1 ELSE 0 END) as pendentea"),
                DB::raw("SUM(CASE WHEN docs.status IN ('concluido', 'enviado', 'recebido', 'em transito', 'em_transito') AND fa.constante='DA' THEN 1 ELSE 0 END) as concluidoa"),
                DB::raw("SUM(CASE WHEN docs.status NOT IN ('recebido') AND fb.constante='DA' THEN 1 ELSE 0 END) as pendenteb"),
                DB::raw("SUM(CASE WHEN docs.status = 'recebido' AND fb.constante='DA' THEN 1 ELSE 0 END) as concluidob"),
                DB::raw("SUM(CASE WHEN docs.status IN ('enviado','em transito', 'em_transito') AND fc.constante='DM' THEN 1 ELSE 0 END) as pendentec"),
                DB::raw("SUM(CASE WHEN docs.status IN ('concluido', 'recebido') AND fc.constante='DM' THEN 1 ELSE 0 END) as concluidoc"),
                DB::raw("SUM(CASE WHEN files.constante='DA' THEN 1 ELSE 0 END) as total_da"),
                DB::raw("SUM(CASE WHEN files.constante='DM' THEN 1 ELSE 0 END) as total_dm"),
                "files.movimento as movimento",
            ])
            ->join("files", "docs.file_id", "=", "files.id")
            ->leftjoin("files as fa", function ($join) use ($user) {
                $join->on("docs.file_id", "=", "fa.id")
                    ->where("fa.constante", "=", "DA");
                if ($user->juncao != null) {
                    $join->where("docs.from_agency", "=", $user->juncao);
                }
            })
            ->leftjoin("files as fb", function ($join) use ($user) {
                $join->on("docs.file_id", "=", "fb.id")
                    ->where("fb.constante", "=", "DA");
                if ($user->juncao != null) {
                    $join->where("docs.to_agency", "=", $user->juncao);
                }
            })
            ->leftjoin("files as fc", function ($join) use ($user) {
                $join->on("docs.file_id", "=", "fc.id")
                    ->where("fc.constante", "=", "DM");
                if ($user->juncao != null) {
                    $join->where("docs.to_agency", "=", $user->juncao);
                }
            })
            ->whereIn("files.constante", ["DA","DM"])
            ->where("files.movimento", '<>', null)
            ->groupBy(["files.movimento"])
        ;

        return DataTables::of($query)
            ->editColumn('movimento', function($doc) {
                return with(new Carbon($doc->movimento))->format('d/m/Y');
            })
            ->addColumn('movimento_sort', function ($doc) {
                return with(new Carbon($doc->movimento))->format('Ymd');
            })
            ->editColumn('pendentea', function($doc) {
                return number_format($doc->pendentea, 0, '', '.');
            })
            ->editColumn('concluidoa', function($doc) {
                return number_format($doc->concluidoa, 0, '', '.');
            })
            ->editColumn('pendenteb', function($doc) {
                return number_format($doc->pendenteb, 0, '', '.');
            })
            ->editColumn('concluidob', function($doc) {
                return number_format($doc->concluidob, 0, '', '.');
            })
            ->editColumn('pendentec', function($doc) {
                return number_format($doc->pendentec, 0, '', '.');
            })
            ->editColumn('concluidoc', function($doc) {
                return number_format($doc->concluidoc, 0, '', '.');
            })
            ->editColumn('total_da', function($doc) {
                return number_format($doc->total_da, 0, '', '.');
            })
            ->editColumn('total_dm', function($doc) {
                return number_format($doc->total_dm, 0, '', '.');
            })

            ->make(true);
    }
}
