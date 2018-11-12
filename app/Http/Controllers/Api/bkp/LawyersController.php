<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Lawyers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class LawyersController extends BaseController
{
    public function list()
    {
        $lawyers = Lawyers::where('id','>', 0)->get();
//        return $this->sendResponse($lawyers->toArray(), 'Informação recuperada com sucesso');
        return Datatables::of($lawyers)
            ->addColumn('action', function ($lawyers) {
                return '<div align="center"><a href="edit/' . $lawyers->id . '" data-toggle="tooltip" title="Editar" class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-pencil-square"></i></a><button onclick="modalDelete(' . $lawyers->id . ')" data-toggle="tooltip" title="Excluir" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-trash"></i></button></div>';
            })
            ->editColumn('birth_date', function ($lawyers) {
                return $lawyers->birth_date ? with(new Carbon($lawyers->birth_date))->format('d/m/Y') : '';
            })
            ->make(true);
    }

    public function index()
    {
        $lawyers = Lawyers::all();

        return Datatables::of($lawyers)
            ->addColumn('action', function ($lawyers) {
                return '<div align="center"><a href="edit/' . $lawyers->id . '" data-toggle="tooltip" title="Editar" class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-pencil-square"></i></a><button onclick="modalDelete(' . $lawyers->id . ')" data-toggle="tooltip" title="Excluir" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-trash"></i></button></div>';
            })
            ->editColumn('birth_date', function ($lawyers) {
                return $lawyers->created_at ? with(new Carbon($lawyers->birth_date))->format('d/m/Y') : '';
            })
            ->make(true);
//        $lawyers = Lawyers::where('id', 0)->get();
 //       return $this->sendResponse($lawyers->toArray(), 'Informação recuperada com sucesso');

    }

    public function store(Request $request)
    {
        $input = $request->all();
        $input['birth_date'] = new \DateTime($input['birth_date']);;
        $lawyer = Lawyers::create($input);
        $ret = "/lawyers/" . $lawyer->id;
        return $this->sendResponse(null, 'Advogado cadastrado com sucesso', $ret);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lawyer = Lawyers::where('id', $id)->first();

        if (is_null($lawyer)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        return $this->sendResponse($lawyer->toArray(), 'Informação recuperada com sucesso');
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
        $lawyer = Lawyers::where('id', $id)->first();


        if (is_null($lawyer)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $input = $request->all();
        $input['birth_date'] = new \DateTime($input['birth_date']);;
        $lawyer->fill($input)->save();

        return $this->sendResponse($lawyer->toArray(), 'Informação atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lawyer = Lawyers::where('id', $id)->first();

        if (is_null($lawyer)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $lawyer->delete();

        return $this->sendResponse(null, 'Informação excluída com sucesso');
    }
}
