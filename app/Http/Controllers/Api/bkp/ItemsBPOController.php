<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\ItemsBPO;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class ItemsBPOController extends BaseController
{

    public function list()
    {
        $items_bpo = ItemsBPO::with('typeExpertise')->get();
//        return $this->sendResponse($clients->toArray(), 'Informação recuperada com sucesso');

        return Datatables::of($items_bpo)
            ->addColumn('action', function ($items_bpo) {
                return '<div align="center"><a href="items_bpo/edit/' . $items_bpo->id . '" data-toggle="tooltip" title="Editar" class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-pencil-square"></i></a><button onclick="modalDelete(' . $items_bpo->id . ')" data-toggle="tooltip" title="Excluir" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-trash"></i></button></div>';
            })
            ->make(true);
    }

    public function index()
    {
        $items_bpo = ItemsBPO::all();
        return $this->sendResponse($items_bpo->toArray(), 'Informação recuperada com sucesso');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $items_bpo = ItemsBPO::create($input);
        $ret = "/items_bpo/" . $items_bpo->id;
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
        $items_bpo = ItemsBPO::where('id', $id)->first();

        if (is_null($items_bpo)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        return $this->sendResponse($items_bpo->toArray(), 'Informação recuperada com sucesso');
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
        $items_bpo = ItemsBPO::where('id', $id)->first();

        if (is_null($items_bpo)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $input = $request->all();

        $items_bpo->fill($input)->save();

        return $this->sendResponse($items_bpo->toArray(), 'Informação atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $items_bpo = ItemsBPO::where('id', $id)->first();

        if (is_null($items_bpo)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $items_bpo->delete();

        return $this->sendResponse(null, 'Excluído com sucesso');
    }
}
