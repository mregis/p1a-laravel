<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Query;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class QueryController extends BaseController
{

    public function list()
    {
        $query = Query::where('id', '>', '0')->get();
//        return $this->sendResponse($clients->toArray(), 'Informação recuperada com sucesso');
        return Datatables::of($query)
            ->addColumn('action', function ($query) {
                return '<div align="center"><a href="query/edit/' . $query->id . '" data-toggle="tooltip" title="Editar" class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-pencil-square"></i></a><button onclick="modalDelete(' . $query->id . ')" data-toggle="tooltip" title="Excluir" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-trash"></i></button></div>';
            })
            ->editColumn('created_at', function ($query) {
                return $query->created_at ? with(new Carbon($query->created_at))->format('d/m/Y H:i') : '';
            })
            ->editColumn('updated_at', function ($query) {
                return $query->updated_at ? with(new Carbon($query->updated_at))->format('d/m/Y H:i') : '';
            })
            ->make(true);
    }

    public function index()
    {
        $query = Query::where('id', '>', '1')->get();
        return $this->sendResponse($query->toArray(), 'Informação recuperada com sucesso');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $query = Query::create($input);
        $ret = "/query/" . $query->id;
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
        $query = Query::where('id', $id)->first();

        if (is_null($query)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        return $this->sendResponse($query->toArray(), 'Informação recuperada com sucesso');
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
        $query = Query::where('id', $id)->first();

        if (is_null($query)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $input = $request->all();

        $query->fill($input)->save();

        return $this->sendResponse($query->toArray(), 'Informação atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $query = Query::where('id', $id)->first();

        if (is_null($query)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $query->delete();

        return $this->sendResponse(null, 'Excluído com sucesso');
    }
}
