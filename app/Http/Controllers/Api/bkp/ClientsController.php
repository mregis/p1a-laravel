<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Clients;
use Yajra\Datatables\Datatables;

class ClientsController extends BaseController
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
        $clients = Clients::all();
	return Datatables::of($clients)->addColumn('action', function ($clients) {
		return '<div align="center"><a href="edit/' . $clients->id . '" data-toggle="tooltip" title="Editar" class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-pencil-square"></i></a><button onclick="modalDelete(' . $clients->id . ')" data-toggle="tooltip" title="Excluir" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-trash"></i></button></div>';
	})->make(true);
    }

    /**
     * @SWG\Post(
     *     path="/clients",
     *     operationId="store",
     *     summary="Adiciona um novo cliente",
     *     tags={"Clients"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Definition(
     *              @SWG\Property(property="parent_id", type="integer"),
     *              @SWG\Property(property="social_name", type="string"),
     *              @SWG\Property(property="fantasy_name", type="string"),
     *              @SWG\Property(property="cpf_cnpj", type="string"),
     *              @SWG\Property(property="rg", type="string"),
     *              @SWG\Property(property="state_registration", type="string"),
     *              @SWG\Property(property="municipal_registration", type="string"),
     *              @SWG\Property(property="financial_officer", type="string"),
     *              @SWG\Property(property="financial_phone", type="string"),
     *              @SWG\Property(property="financial_email", type="string"),
     *              @SWG\Property(property="zipcode", type="string"),
     *              @SWG\Property(property="state_id", type="string"),
     *              @SWG\Property(property="city", type="string"),
     *              @SWG\Property(property="number", type="string"),
     *              @SWG\Property(property="address", type="string"),
     *              @SWG\Property(property="district", type="string"),
     *              @SWG\Property(property="complement", type="string"),
     *         )
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Informação adicionada com sucesso",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Erro na validação dos dados",
     *     )
     * )
     */
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
