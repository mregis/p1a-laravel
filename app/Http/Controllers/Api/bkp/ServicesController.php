<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Services;
use App\Models\Clients;
use Yajra\Datatables\Datatables;

class ServicesController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {

        $clients = Clients::where('id','>', 0)->get();
        return $this->sendResponse($clients->toArray(), 'Informação recuperada com sucesso');

    }
    public function index()
    {
        $services = Services::all();
	foreach($services as &$service){
		$client = Clients::where('id', $service->client_id)->first();
		$service->client = $client->social_name; 
	}
	return Datatables::of($services)->addColumn('action', function ($services) {
		return '<div align="center"><a href="edit/' . $services->id . '" data-toggle="tooltip" title="Editar" class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-pencil-square"></i></a><button onclick="modalDelete(' . $services->id . ')" data-toggle="tooltip" title="Excluir" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-trash"></i></button></div>';
	})->make(true);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $client = Clients::create($input);
        $ret = "/clients/" . $client->id;
        return $this->sendResponse(null, 'Cliente cadastrado com sucesso', $ret);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Clients::where('id', $id)->first();

        if (is_null($client)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        return $this->sendResponse($client->toArray(), 'Informação recuperada com sucesso');
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
        $client = Clients::where('id', $id)->first();

        if (is_null($client)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $input = $request->all();

        $client->fill($input)->save();

        return $this->sendResponse($client->toArray(), 'Informação atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Clients::where('id', $id)->first();

        if (is_null($client)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $client->delete();

        return $this->sendResponse(null, 'Informação excluída com sucesso');
    }
}
