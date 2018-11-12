<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Goods;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class GoodsController extends BaseController
{

    public function list()
    {
        $goods = Goods::where('id','>', 0)->get();
//        return $this->sendResponse($clients->toArray(), 'Informação recuperada com sucesso');
        return Datatables::of($goods)
            ->addColumn('action', function ($goods) {
                return '<div align="center"><a href="goods/edit/' . $goods->id . '" data-toggle="tooltip" title="Editar" class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-pencil-square"></i></a><button onclick="modalDelete(' . $goods->id . ')" data-toggle="tooltip" title="Excluir" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-trash"></i></button></div>';
            })
            ->editColumn('created_at', function ($goods) {
                return $goods->created_at ? with(new Carbon($goods->created_at))->format('d/m/Y H:i') : '';
            })
            ->editColumn('updated_at', function ($goods) {
                return $goods->updated_at ? with(new Carbon($goods->updated_at))->format('d/m/Y H:i') : '';
            })
            ->make(true);
    }

    public function index()
    {
        $goods = Goods::where('id', '>', '1')->get();
        return $this->sendResponse($goods->toArray(), 'Informação recuperada com sucesso');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $goods = Goods::create($input);
        $ret = "/goods/" . $goods->id;
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
        $goods = Goods::where('id', $id)->first();

        if (is_null($goods)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        return $this->sendResponse($goods->toArray(), 'Informação recuperada com sucesso');
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
        $goods = Goods::where('id', $id)->first();

        if (is_null($goods)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $input = $request->all();

        $goods->fill($input)->save();

        return $this->sendResponse($goods->toArray(), 'Informação atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $goods = Goods::where('id', $id)->first();

        if (is_null($goods)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $goods->delete();

        return $this->sendResponse(null, 'Excluído com sucesso');
    }
}
