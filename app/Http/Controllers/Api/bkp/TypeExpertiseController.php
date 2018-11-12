<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\TypeExpertise;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class TypeExpertiseController extends BaseController
{

    public function list()
    {
        $type_expertise = TypeExpertise::where('id', '>', 0)->get();
//        return $this->sendResponse($clients->toArray(), 'Informação recuperada com sucesso');

        return Datatables::of($type_expertise)
            ->addColumn('action', function ($type_expertise) {
                return '<div align="center"><a href="edit/' . $type_expertise->id . '" data-toggle="tooltip" title="Editar" class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-pencil-square"></i></a><button onclick="modalDelete(' . $type_expertise->id . ')" data-toggle="tooltip" title="Excluir" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-trash"></i></button></div>';
            })
            ->make(true);
    }

    public function index()
    {
        $type_expertise = TypeExpertise::orderBy('name')
            ->get();
        return $this->sendResponse($type_expertise->toArray(), 'Informação recuperada com sucesso');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $type_expertise = TypeExpertise::create($input);
        $ret = "/questions/" . $type_expertise->id;
        return $this->sendResponse(null, 'Perícia cadastrada com sucesso', $ret);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $type_expertise = TypeExpertise::where('id', $id)->first();

        if (is_null($type_expertise)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        return $this->sendResponse($type_expertise->toArray(), 'Informação recuperada com sucesso');
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
        $type_expertise = TypeExpertise::where('id', $id)->first();

        if (is_null($type_expertise)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $input = $request->all();

        $type_expertise->fill($input)->save();

        return $this->sendResponse($type_expertise->toArray(), 'Informação atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type_expertise = TypeExpertise::where('id', $id)->first();

        if (is_null($type_expertise)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $type_expertise->delete();

        return $this->sendResponse(null, 'Perícia excluída com sucesso');
    }
}
