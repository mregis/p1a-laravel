<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Auth;

class DashboardController extends Controller
{
    public function index() {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('dashboard.index', compact('menus'));
    }

}
