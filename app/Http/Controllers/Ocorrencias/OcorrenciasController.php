<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 22/02/2019
 * Time: 18:44
 */

namespace app\Http\Controllers\Ocorrencias;


use App\Http\Controllers\BaseController;
use App\Models\Menu;

class OcorrenciasController extends BaseController
{

    public function index() {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('ocorrencias.index', compact('menus'));
    }

    public function reportarRoubo() {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('ocorrencias.report_theft', compact('menus'));
    }

    public function _add() {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('ocorrencias.add', compact('menus'));
    }
}