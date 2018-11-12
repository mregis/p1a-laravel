<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\ItemsCheck;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class ItemsCheckController extends BaseController
{

    public function list()
    {
        $items_check = ItemsCheck::with('itemBpo', 'user', 'itemBpo.typeExpertise')->get();
//        return $this->sendResponse($clients->toArray(), 'Informação recuperada com sucesso');

        return Datatables::of($items_check)
            ->addColumn('action', function ($items_check) {
                if (!$items_check->check) {
                    $check = '<button onclick="obsCheck(' . $items_check->id . ')" data-toggle="tooltip" title="Não feito" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-times"></i></button>';
                } else {
                    $check = '<button onclick="modalNegateCheck(' . $items_check->id . ')" data-toggle="tooltip" title="Feito" class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-check-square"></i></button>';
                }
                return '<div align="center">' . $check . '<a href="items_check/edit/' . $items_check->id . '" data-toggle="tooltip" title="Editar" class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-pencil-square"></i></a><button onclick="modalDelete(' . $items_check->id . ')" data-toggle="tooltip" title="Excluir" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-trash"></i></button></div>';
            })
            ->editColumn('end_date', function ($items_check) {
                return $items_check->end_date ? with(new Carbon($items_check->end_date))->format('d/m/Y H:i') : '';
            })
            ->editColumn('created_at', function ($items_check) {
                return $items_check->created_at ? with(new Carbon($items_check->created_at))->format('d/m/Y H:i') : '';
            })
            ->editColumn('updated_at', function ($items_check) {
                return $items_check->updated_at ? with(new Carbon($items_check->updated_at))->format('d/m/Y H:i') : '';
            })
            ->make(true);
    }

    public function index()
    {
        $items_check = ItemsCheck::all();
        return $this->sendResponse($items_check->toArray(), 'Informação recuperada com sucesso');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $input['end_date'] = new DateTime($input['end_date']);
        $items_check = ItemsCheck::create($input);
        $ret = "/items_check/" . $items_check->id;
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
        $items_check = ItemsCheck::where('id', $id)->first();

        if (is_null($items_check)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        return $this->sendResponse($items_check->toArray(), 'Informação recuperada com sucesso');
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
        $items_check = ItemsCheck::where('id', $id)->first();

        if (is_null($items_check)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $input = $request->all();
        $input['start_date'] = new DateTime($input['start_date']);
        $input['end_date'] = new DateTime($input['end_date']);
        $items_check->fill($input)->save();

        return $this->sendResponse($items_check->toArray(), 'Informação atualizada com sucesso');
    }

    public function check(Request $request)
    {
        $input = $request->all();
        $items_check = ItemsCheck::where('id', $input['id'])->first();
        if (is_null($items_check)) {
            return $this->sendError('Informação não encontrada', 404);
        }
        $input['check'] = 1;
        $items_check->fill($input)->save();
        return $this->sendResponse($items_check->toArray(), 'Informação atualizada com sucesso');
    }

    public function negateCheck($id)
    {
        $items_check = ItemsCheck::where('id', $id)->first();
        if (is_null($items_check)) {
            return $this->sendError('Informação não encontrada', 404);
        }
        $input['check'] = 0;
        $items_check->fill($input)->save();
        return $this->sendResponse($items_check->toArray(), 'Informação atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $items_check = ItemsCheck::where('id', $id)->first();

        if (is_null($items_check)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $items_check->delete();

        return $this->sendResponse(null, 'Excluído com sucesso');
    }
}
