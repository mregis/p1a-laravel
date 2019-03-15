<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 14/03/2019
 * Time: 15:35
 */

namespace App\Http\Controllers\Recebimento;


use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class RecebimentoController extends BaseController
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function operador(Request $request)
    {
        $menus = $this->menu->menu();

        return view('recebimento.operador', compact('menus'));
    }
}