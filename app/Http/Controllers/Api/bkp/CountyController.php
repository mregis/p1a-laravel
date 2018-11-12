<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\County;

class CountyController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	$county = County::where('id','>', 0)->get();
	return $this->sendResponse($county->toArray(), 'Informação recuperada com sucesso');
    }

    /**
     * @SWG\Post(
     *     path="/County",
     *     operationId="store",
     *     summary="Adiciona um novo cliente",
     *     tags={"County"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Definition(
     *              @SWG\Property(property="name", type="string"),
     *              @SWG\Property(property="description", type="string"),
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
        $input   = $request->all();
        $county  = County::create($input);
	$ret = "/County/".$county->id;
        return $this->sendResponse(null, 'Comarca cadastrada com sucesso',$ret);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $county  = County::where('id', $id)->first();

        if (is_null($county)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        return $this->sendResponse($county->toArray(), 'Informação recuperada com sucesso');
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
        $county  = County::where('id', $id)->first();

        if (is_null($county)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $input = $request->all();

        $county->fill($input)->save();

        return $this->sendResponse($county->toArray(), 'Informação atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $county = County::where('id', $id)->first();

        if (is_null($county)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $county->delete();

        return $this->sendResponse(null, 'Informação excluída com sucesso');
    }
}
