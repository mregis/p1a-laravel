<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 10/12/2018
 * Time: 23:37
 */

namespace app\Http\Controllers\Unidade;


use App\Http\Controllers\Controller;
use App\Models\Audit;
use App\Models\Unidade;
use App\Models\Menu;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

use Validator;
use PDF;

class UnidadeController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('unidade.index', compact('menus'));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function _new()
    {
        $menu = new Menu();
        $menus = $menu->menu();
        $unidade = new Unidade();
        return view('unidade.new', compact('menus', 'unidade'));
    }

    /**
     * @param Request $request
     * @param $unidade_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $unidade_id)
    {
        if (!$unidade = Unidade::find($unidade_id)) {
            $request->session()->flash('alert-danger', 'Não foi possível encontrar o cadastro!');
            return redirect(route('unidades.index'));
        }
        $menu = new Menu();
        $menus = $menu->menu();
        return view('unidade.edit', compact('menus', 'unidade'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|between:5,20',
            'descricao' => 'required|between:5,100',
        ]);

        if ($validator->fails()) {
            $request->session()->flash('alert-danger', 'Erros encontrados. Verifique as informações e tente novamente!');
            return redirect(route('unidade.novo'))
                ->withErrors($validator)
                ->withInput();
        }

        if ($unidade = Unidade::create($request->all())) {
            $request->session()->flash('alert-success', 'Cadastro criado com sucesso!');
            Audit::create([
                'description' => sprintf('Cadastro Unidade [%s] criado', $unidade->nome),
                'user_id' => $unidade->id
            ]);
        } else {
            $request->session()->flash('alert-danger', 'Ocorreu um erro ao tentar criar o cadastro!');
        }

        return redirect(route('unidades.index'));
    }
}