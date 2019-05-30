<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 14/03/2019
 * Time: 15:35
 */

namespace App\Http\Controllers\Recebimento;


use App\Http\Controllers\BaseController;
use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RecebimentoController extends BaseController
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function operador(Request $request)
    {
        // Acesso somente a determinados ususarios
        if (!$unidade = Unidade::where('nome', trim(Auth::user()->unidade))->first()) {
            $request->session()->flash('alert-danger', 'Você não tem permissão de acessar este recurso!');
            return redirect(route('home'));
        }
        $menus = $this->menu->menu();
        return view('recebimento.operador', compact('menus'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function carregarArquivoLeituras(Request $request)
    {
        // Acesso somente a determinados ususarios
        if (!$unidade = Unidade::where('nome', trim(Auth::user()->unidade))->first()) {
            $request->session()->flash('alert-danger', 'Você não tem permissão de acessar este recurso!');
            return redirect(route('home'));
        }
        $menus = $this->menu->menu();
        $unidades = Unidade::all();
        return view('recebimento.carregar-arquivo', compact('menus', 'unidades'));
    }
}