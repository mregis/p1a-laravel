<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\BaseController;
use App\Models\Menu;
use App\Models\Profile;
use App\User;
use App\Models\Products;
use App\Models\Alerts;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Auth;

class CadastrosController extends BaseController
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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('users.users_add', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu = new Menu();
        $user = User::where('id', $id)->first();
        $menus = $menu->menu();

        return view('users.users_edit', compact('user', 'menus'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function produtos()
    {
        $menu = new Menu();
        $menus = $menu->menu();
        $produtos = Products::all();
        return view('cadastros.produtos', compact('menus', 'produtos'));
    }

    public function alert_add()
    {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('cadastros.alerts', compact('menus'));
    }

    public function alert_list()
    {
        $menu = new Menu();
        $menus = $menu->menu();
        $alerts = Alerts::with(['user','product'])->get();

        // List of Basic Ocorrencia Types
        $ocorrencia_types = [];
        $reflectionClass = new \ReflectionClass(Alerts::class);
        foreach ($reflectionClass->getReflectionConstants() as $constant) {
            if (strpos($constant->getName(), 'TYPE_') > -1) {
                $ocorrencia_types[] = $constant->getValue();
            }
        }

        // List of Products
        $products = Products::all();
        return view('cadastros.alerts_list', compact('menus', 'alerts', 'ocorrencia_types', 'products'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function alert_edit(Request $request, $id)
    {
        if (!$alert = Alerts::find($id)) {
            $request->session()->flash('alert-danger', 'Informação não encontrada');
            return redirect(route('cadastros.list_alert'));
        }

        $menu = new Menu();
        $menus = $menu->menu();

        return view('cadastros.alerts_edit', compact('menus', 'alert'));
    }

    public function alert_remove(Request $request, $id)
    {
        if(!$alert = Alerts::find($id)) {
            $request->session()->flash('alert-danger', 'Informação não encontrada');
            return redirect(route('cadastros.list_alert'));
        }
        $alert->delete();
        $request->session()->flash('alert-success', 'Ocorrência atualizada');
        return redirect(route('cadastros.list_alert'));
    }

    public function produto_edit(Request $request, $id)
    {
        $menu = new Menu();
        $menus = $menu->menu();
        $produtos = Products::all();
        $produto = Products::find($id);
        return view('cadastros.produtos', compact('menus', 'produtos', 'produto'));
    }

    public function produto_remove(Request $request, $id)
    {
        if (!$produtos = Products::find($id)) {
            $request->session()->flash('alert-danger', 'Informação não encontrada');
            return redirect('/cadastros/produtos');
        }
        $produtos->delete();
        return $this->produtos();
    }

    public function contingencia()
    {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('cadastros.contingencia', compact('menus'));
    }


    public function perfis()
    {
        if (!Auth::user()) return redirect('/');
        $menu = new Menu();
        $menus = $menu->menu();
        $profiles = Profile::where('id', '>', 0)->get();
        return view('cadastros.profiles', compact('menus', 'profiles'));
    }

    public function perfil_edit(Request $request, $id)
    {
        $menu = new Menu();
        $menus = $menu->menu();
        $profiles = Profile::all();
        $profile = Profile::find($id);
        return view('cadastros.profiles', compact('menus', 'profiles', 'profile'));
    }

    public function perfil_remove(Request $request, $id)
    {
        $profile = Profile::where('id', $id)->first();
        $profile->delete();
        return $this->perfis();
    }
}
