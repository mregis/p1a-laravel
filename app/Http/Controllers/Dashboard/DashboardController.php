<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Models\Menu;
use Auth;

class DashboardController extends BaseController
{
    public function index() {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('dashboard.index', compact('menus'));
    }

}
