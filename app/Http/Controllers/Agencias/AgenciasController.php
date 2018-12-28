<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 10/12/2018
 * Time: 23:37
 */

namespace app\Http\Controllers\Agencias;


use App\Http\Controllers\Controller;
use App\Models\Agencia;
use App\Models\Menu;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

use Validator;
use PDF;

class AgenciasController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('agencia.index', compact('menus'));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function _new()
    {
        $menu = new Menu();
        $menus = $menu->menu();
        $agencia = new Agencia();
        return view('agencia.new', compact('menus', 'agencia'));
    }

    public function show()
    {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('agencia.show', compact('menus'));
    }

    /**
     * @param Request $request
     * @param $agencia_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $agencia_id)
    {
        if (!$agencia = Agencia::find($agencia_id)) {
            $request->session()->flash('alert-danger', 'Não foi possível encontrar o cadastro!');
            return redirect(route('agencias.index'));
        }
        $menu = new Menu();
        $menus = $menu->menu();
        return view('agencia.edit', compact('menus', 'agencia'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|digits:4|not_in:0000',
            'nome' => 'required|between:5,100',
            'cd' => 'required',
            'cep' => 'required|between:8,9|not_in:00000000,00000-000',
            'endereco' => 'required|between:5,100',
            'uf' => 'required|in:SP,RJ,MG,RS,AC,AL,AM,AP,BA,CE,DF,ES,GO,MA,MT,MS,PA,PB,PR,PE,PI,RN,RO,RR,SC,SE,TO',
            'cidade' => 'required|between:5,100',
            'bairro' => 'nullable|between:5,100',
        ]);

        if ($validator->fails()) {
            $request->session()->flash('alert-danger', 'Erros encontrados. Verifique as informações e tente novamente!');
            return redirect(route('agencias.novo'))
                ->withErrors($validator)
                ->withInput();
        }

        if ($agencia = Agencia::create($request->all())) {
            $request->session()->flash('alert-success', 'Cadastro criado com sucesso!');
        } else {
            $request->session()->flash('alert-danger', 'Ocorreu um erro ao tentar criar o cadastro!');
        }

        return redirect(route('agencias.index'));
    }
}