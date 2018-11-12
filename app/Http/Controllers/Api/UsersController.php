<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends BaseController
{
    public function list()
    {
        $users = Users::all();
        return Datatables::of($users)
            ->addColumn('action', function ($users) {
                return '<div align="center"><a href="edit/' . $users->id . '" data-toggle="tooltip" title="Editar" class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-pencil-square"></i></a><button onclick="modalDelete(' . $users->id . ')" data-toggle="tooltip" title="Excluir" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-trash"></i></button></div>';
            })
            ->editColumn('birth_date', function ($Users) {
                return $Users->created_at ? with(new Carbon($Users->birth_date))->format('d/m/Y') : '';
            })
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('users.users_list', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
	$input['password'] = Hash::make($input['password']);
        $user = Users::create($input);
        $ret = "/users/" . $user->id;
        return $this->sendResponse(null, 'Cadastrado com sucesso', $ret);

    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user = Users::where('id', $id)->first();

        if (is_null($user)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        return $this->sendResponse($user->toArray(), 'Informação recuperada com sucesso');
        //
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
        $user = Users::where('id', $id)->first();

        if (is_null($user)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $input = $request->all();
        if ($input['password'] != $input['confirm_password']) {
            return $this->sendError('As senhas estão divergentes', 404);
        }

	$input['password'] = Hash::make($input['password']);

        $user->fill($input)->save();

        return $this->sendResponse($user->toArray(), 'Informação atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Users::where('id', $id)->first();

        if (is_null($user)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $user->delete();

        return $this->sendResponse(null, 'Informação excluída com sucesso');
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
        $user = Users::where('id', $id)->first();
        $menus = $menu->menu();

        $permissao = $this->getEnum();

        return view('users.users_edit', compact('user', 'menus','permissao'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public
    function create()
    {
        $menu = new Menu();
        $menus = $menu->menu();

        $permissao = $this->getEnum();

        return view('users.users_add', compact('menus','permissao'));
    }

    /**
     * Show enum values.
     *
     * @return \Illuminate\Http\Response
     */
    public
    function getEnum()
    {
      $type = DB::select(DB::raw('SHOW COLUMNS FROM users WHERE Field = "profile"'))[0]->Type;
      preg_match('/^enum\((.*)\)$/', $type, $matches);
      $values = array();

      foreach(explode(',', $matches[1]) as $value){
          $permissao[] = trim($value, "'");
      }
      return $permissao;
    }
}
