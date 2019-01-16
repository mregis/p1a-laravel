<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Alerts;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AlertsController extends BaseController
{

    public function listAlerts(Request $request)
    {
        $query = Alerts::with(['user', 'product']);
        return Datatables::of($query)
            ->addColumn('action', function ($alert) {
                return sprintf('<a href="%s" data-toggle="tooltip" title="Editar" ' .
                    'class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only">' .
                    '<i class="fas fa-edit"></i></a><button onclick="modalDelete(' . $alert->id . ')" ' .
                    'data-toggle="tooltip" title="Excluir" ' .
                    'class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only">' .
                    '<i class="fas fa-trash-alt"></i></button>',
                    route('cadastros.edit_alert', $alert->id));
            })
            ->editColumn('created_at', function ($alert) {
                return $alert->created_at ? with(new Carbon($alert->created_at))->format('d/m/Y H:i') : '';
            })
            ->editColumn('updated_at', function ($alert) {
                return $alert->updated_at ? with(new Carbon($alert->updated_at))->format('d/m/Y H:i') : '';
            })
            ->editColumn('description', function($alert) {
                return sprintf('<div class="text-left" style="white-space: normal"><ul><li>%s</li></ul></div>',
                    implode('</li><li>', explode("\n", $alert->description)));
            })
            ->addColumn('user.local', function($alert) {
                return $alert->user->getLocal();
            })
            ->rawColumns(['description', 'action'])
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
        return view('cadastros.alerts_list', compact('menus'));
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
        $input['user_id'] = $input['_u'];
        $input['product_id'] = $input['product'];
        $alert = Alerts::create($input);

        return $this->sendResponse(null, 'Cadastrado com sucesso', $alert);

    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        if (!$alert = Alerts::find($id)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        return $this->sendResponse($alert->toArray(), 'Informação recuperada com sucesso');
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

        if (!$alert = Alerts::find($id)) {
            return $this->sendError('Informação não encontrada', 404);
        }
        $input = $request->all();
        $alert->description .= "\n[" . date('d-m-Y H:i') .'] ' . $input['description'];
        $alert->save();
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
        if (!$alert = Alerts::find($id)) {
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
        if (!$alert =  Alerts::find($id)) {
            return $this->sendError('Informação não encontrada', 404);
        }
        $menu = new Menu();
        $menus = $menu->menu();
        return view('alerts.alerts_list', compact('alert', 'menus'));
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

        return view('alerts.alerts_add', compact('menus','permissao'));
    }

}
