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
    public function list()
    {
        return Datatables::of(Audit::query())
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
