<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use App\Menu;
use App\User;
use App\Models\Products;
use App\Models\Alerts;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Auth;

class CadastrosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
	if(!Auth::user()) return redirect('/');
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
	if(!Auth::user()) return redirect('/');
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
    public
    function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
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
	if(!Auth::user()) return redirect('/');
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
    public
    function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        //
    }
    public function produtos()
    {
	if(!Auth::user()) return redirect('/');
        $menu = new Menu();
        $menus = $menu->menu();
	$produtos = Products::where('id','>' ,0)->get();
        return view('cadastros.produtos', compact('menus','produtos'));
    }
    public function alert_add()
    {
	if(!Auth::user()) return redirect('/');
        $menu = new Menu();
        $menus = $menu->menu();
        return view('cadastros.alerts', compact('menus'));
    }
    public function alert_list()
    {
	if(!Auth::user()) return redirect('/');
        $menu = new Menu();
        $menus = $menu->menu();
	$alerts = Alerts::where('id','>' ,0)->get();
        foreach($alerts as &$a){
            $a->user = User::where('id', $a->user_id)->first();
        }

        return view('cadastros.alerts_list', compact('menus','alerts'));
    }
    public function alert_edit(Request $request, $id)
    {
	if(!Auth::user()) return redirect('/');
        $menu = new Menu();
        $menus = $menu->menu();
        $alert = Alerts::where('id', $id)->first();
        return view('cadastros.alerts_edit', compact('menus','alert'));
    }
    public function alert_remove(Request $request, $id)
    {
        $alert = Alerts::where('id', $id)->first();
        $alert->delete();
	return $this->alert_list();
    }
    public function produto_edit(Request $request, $id)
    {
        $menu = new Menu();
        $menus = $menu->menu();
	$produtos = Products::where('id','>' ,0)->get();
	$produto = Products::where('id',$id)->first();
        return view('cadastros.produtos', compact('menus','produtos','produto'));
    }
    public function produto_remove(Request $request, $id)
    {
        $produtos = Products::where('id', $id)->first();
        $produtos->delete();
	return $this->produtos();
    }
    public function contingencia()
    {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('cadastros.contingencia', compact('menus'));
    }
}
