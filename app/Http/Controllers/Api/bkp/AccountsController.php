<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Accounts;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class AccountsController extends BaseController
{
    public function list()
    {
        $accounts = Accounts::with('bank')->get();
//        return $this->sendResponse($bank->toArray(), 'Informação recuperada com sucesso');

        return Datatables::of($accounts)
            ->addColumn('action', function ($accounts) {
                return '<div align="center"><a href="accounts/edit/' . $accounts->id . '" data-toggle="tooltip" title="Editar" class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-pencil-square"></i></a><button onclick="modalDelete(' . $accounts->id . ')" data-toggle="tooltip" title="Excluir" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-trash"></i></button></div>';
            })
            ->make(true);
    }

    public function index()
    {
        $accounts = Accounts::where('id', 0)->get();
        return $this->sendResponse($accounts->toArray(), 'Informação recuperada com sucesso');

    }

    public function store(Request $request)
    {
        $input = $request->all();
        $account = Accounts::create($input);
        $ret = "/account/" . $account->id;
        return $this->sendResponse(null, 'Conta cadastrado com sucesso', $ret);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $account = Accounts::where('id', $id)->first();

        if (is_null($account)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        return $this->sendResponse($account->toArray(), 'Informação recuperada com sucesso');
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
        $account = Accounts::where('id', $id)->first();

        if (is_null($account)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $input = $request->all();

        $account->fill($input)->save();

        return $this->sendResponse($account->toArray(), 'Informação atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account = Accounts::where('id', $id)->first();

        if (is_null($account)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $account->delete();

        return $this->sendResponse(null, 'Informação excluída com sucesso');
    }
}
