<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Banks;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class BanksController extends BaseController
{
    public function list()
    {
        $banks = Banks::where('id','>', 0)->get();
//        return $this->sendResponse($bank->toArray(), 'Informação recuperada com sucesso');

        return Datatables::of($banks)
            ->addColumn('action', function ($banks) {
                return '<div align="center"><a href="banks/edit/' . $banks->id . '" data-toggle="tooltip" title="Editar" class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-pencil-square"></i></a><button onclick="modalDelete(' . $banks->id . ')" data-toggle="tooltip" title="Excluir" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-trash"></i></button></div>';
            })
            ->make(true);
    }

    public function index()
    {
        $banks = Banks::all();
        return $this->sendResponse($banks->toArray(), 'Informação recuperada com sucesso');

    }

    public function store(Request $request)
    {
        $input = $request->all();
        $bank = Banks::create($input);
        $ret = "/bank/" . $bank->id;
        return $this->sendResponse(null, 'Banco cadastrado com sucesso', $ret);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bank = Banks::where('id', $id)->first();

        if (is_null($bank)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        return $this->sendResponse($bank->toArray(), 'Informação recuperada com sucesso');
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
        $bank = Banks::where('id', $id)->first();

        if (is_null($bank)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $input = $request->all();

        $bank->fill($input)->save();

        return $this->sendResponse($bank->toArray(), 'Informação atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bank = Banks::where('id', $id)->first();

        if (is_null($bank)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $bank->delete();

        return $this->sendResponse(null, 'Informação excluída com sucesso');
    }
}
