<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Profile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;


class ProfileController extends BaseController
{
    public function list()
    {
        $profiles = Profile::all();
        return Datatables::of($profiles)
            ->addColumn('action', function ($profile) {
                return '<div align="center"><a href="edit/' . $profile->id .
                    '" data-toggle="tooltip" title="Editar" ' .
                    'class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only">' .
                    '<i class="fa fa-pencil-square"></i></a>' .
                    '<button onclick="modalDelete(' . $profile->id . ')" data-toggle="tooltip" ' .
                    'title="Excluir" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only">' .
                    '<i class="fa fa-trash"></i></button></div>';
            })
            ->editColumn('created_at', function ($profiles) {
                return $profile->created_at ? with(new Carbon($profile->created_at))->format('d/m/Y') : '';
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
        return view('cadastros.profile_list', compact('menus'));
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
        $product = Profile::create($input);
        return $this->sendResponse(null, 'Cadastrado com sucesso', $product);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user = Profile::where('id', $id)->first();

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
        $alert = Profile::where('id', $id)->first();
        if (is_null($alert)) {
            return $this->sendError('Informação não encontrada', 404);
        }
        $input = $request->all();
	$input['id'] = $id;
	$input["date_ref"] = explode("/",$input["date_ref"]);
	$input["date_ref"] = $input["date_ref"][2]."-".$input["date_ref"][1]."-".$input["date_ref"][0];
        $alert->fill($input)->save();
        return $this->sendResponse($alert->toArray(), 'Informação atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $alert = Profile::where('id', $id)->first();

        if (is_null($alert)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $alert->delete();

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
        $profile = Profile::where('id', $id)->first();
        $menus = $menu->menu();
        return view('Profile.profile_edit', compact('profile', 'menus'));
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
        return view('Profile.profile_add', compact('menus'));
    }

}
