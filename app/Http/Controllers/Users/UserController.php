<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\BaseController;
use App\Models\Agencia;
use App\Models\Audit;
use App\Models\Menu;
use App\Models\Profile;
use App\Models\Unidade;
use App\Models\Users;
use App\User;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Hash;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('users.users_list', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $menu = new Menu();
        $menus = $menu->menu();
        $usuario = new Users();
        $perfis = Profile::all();
        $unidades = Unidade::all();
        return view('users.new', compact('menus', 'usuario', 'perfis', 'unidades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_data = $request->all();
        $validator = Validator::make($user_data, [
            'name' => 'required|between:5,100',
            'email' => 'required|email',
            'password' => 'confirmed',
            'profile' => 'required',
        ]);

        $validator->after(function ($validator) use (&$user_data) {
            // check Email
            if ($user = Users::where('email', $user_data['email'])->first()) {
                $validator->errors()->add('email',
                    'Já existe um usuário com este e-mail');
            }
            // check Profile
            if (!$profile = Profile::where('nome', $user_data['profile'])->first()
            ) {
                $validator->errors()->add('profile',
                    'Perfil inválido! Verifique as informações. Persistindo o problema contate o Administrador');
            }
            // If the user has profile is AGÊNCIA
            if ($profile->nome == 'AGÊNCIA') {
                $juncao = preg_replace('#^(\d+):.*?$#', '$1', $user_data['juncao']);
                if (!$agencia = Agencia::where('codigo', $juncao)->first()) {
                    $validator->errors()->add('juncao', 'Obrigatório indicar uma Agência válida para o perfil indicado!');
                }
                $user_data['juncao'] = $juncao;
                $user_data['unidade'] = null;
            } elseif ($profile->nome == 'OPERADOR') { // If the user has profile is OPERADOR
                if (!$unidade = Unidade::where('nome', $user_data['unidade'])->first()) {
                    $validator->errors()->add('unidade', 'Obrigatório indicar uma Unidade válida para o perfil indicado!');
                }
                $user_data['juncao'] = null;
            }

        });

        if ($validator->fails()) {
            $request->session()->flash('alert-danger', 'Erros encontrados. Verifique as informações e tente novamente!');
            return redirect(route('users.users_save'))
                ->withErrors($validator)
                ->withInput($request->all());
        }

        $user_data['password'] = Hash::make($user_data['password']);

        if ($user = Users::create($user_data)) {
            Audit::create([
                'description' => sprintf('Usuario [%s] criado', $user->name),
                'user_id' => Auth::id()
            ]);
            $request->session()->flash('alert-success', 'Cadastro criado com sucesso!');
        } else {
            $request->session()->flash('alert-danger', 'Ocorreu um erro ao tentar criar o cadastro!');
        }

        return redirect(route('users.users_index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        if (!$usuario = User::find($id)) {
            $request->session()->flash('alert-danger', 'Erro ao recuperar informações. ' .
                'Tente novamente. Se o problema persistir informe ao Administrador do Sistema');
            return redirect(route('users.users_index'));
        }
        $menu = new Menu();

        $menus = $menu->menu();
        $perfis = Profile::all();
        $unidades = Unidade::all();
        return view('users.edit', compact('menus', 'usuario', 'perfis', 'unidades'));
    }

}
