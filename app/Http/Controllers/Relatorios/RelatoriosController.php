<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 11/02/2019
 * Time: 17:31
 */

namespace App\Http\Controllers\Relatorios;


use App\Http\Controllers\BaseController;
use App\Models\Menu;

class RelatoriosController extends BaseController
{

    public function analytic()
    {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('report.analytic', compact('menus'));
    }
}