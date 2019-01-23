<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Users;
use App\Models\Audit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuditController extends BaseController
{
    public function listAudit()
    {
        $query = Audit::query()
            ->select([
                "audit.description", "audit.created_at",
                "users.name as name", "users.email as email", "users.profile as profile"])
            ->leftJoin("users", "audit.user_id", "=", "users.id");

        return Datatables::of($query)
            ->filterColumn('description', function($query, $keyword) {
                $query->orWhere('audit.description', 'like', '%' . $keyword . '%');
            })
            ->filterColumn('name', function($query, $keyword) {
                $query->orWhere('users.name', 'like', '%' . $keyword . '%');
            })
            ->filterColumn('email', function($query, $keyword) {
                $query->orWhere('users.email', $keyword);
            })
            ->filterColumn('profile', function($query, $keyword) {
                $query->orWhere('users.profile', $keyword);
            })
            ->editColumn('created_at', function ($audit) {
                return $audit->created_at ? with(new Carbon($audit->created_at))->format('d/m/Y H:i:s') : '';
            })
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('audit.audit_list', compact('menus'));
    }
}
