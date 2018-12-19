<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use Auth;
use App\Models\Files;
use App\Models\Docs;

class DashboardController extends Controller
{
    public function index() {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('dashboard.index', compact('menus'));
    }
    
}
