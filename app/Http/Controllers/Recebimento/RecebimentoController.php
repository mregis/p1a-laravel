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
use Illuminate\Support\Facades\Cache;

class RecebimentoController extends BaseController
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function operador()
    {
        $menus = $this->menu->menu();
        return view('recebimento.operador', compact('menus'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function carregarArquivoLeituras()
    {
        $menus = $this->menu->menu();
        return view('recebimento.carregar-arquivo', compact('menus'));
    }
}