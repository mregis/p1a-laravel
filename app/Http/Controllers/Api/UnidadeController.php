<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 10/12/2018
 * Time: 23:37
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\BaseController;
use App\Models\Unidade;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Request;
use Yajra\DataTables\DataTables;
use DB;
use Validator;

class UnidadeController extends BaseController
{

    public function _list() 
    {
        $query = Unidade::query();
        return DataTables::of($query)
            ->addColumn('action', function ($unidade) {
                return '<div align="center"><a href="' . route('unidade.editar', $unidade->id) .
                '" data-toggle="tooltip" title="Editar" ' .
                'class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only">' .
                '<i class="fas fa-edit"></i></a><button onclick="actionAjax(\'' .
                route('unidade.api-remover', $unidade->id) . '\',\'delete\')"' .
                'data-toggle="tooltip" title="Excluir" ' .
                'class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only">' .
                '<i class="fas fa-trash-alt"></i></button></div>';
            })

            ->editColumn('updated_at', function ($unidade) {
                return $unidade->updated_at ? with(new Carbon($unidade->updated_at))->format('d/m/Y H:i') : '';
            })
            ->editColumn('created_at', function ($unidade) {
                return $unidade->created_at? with(new Carbon($unidade->created_at))->format('d/m/Y H:i') : '';
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * @param Request $request
     * @param $unidade_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $unidade_id)
    {
        if (!$unidade = Unidade::find($unidade_id)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $validator = Validator::make($request->all(), [
            'nome' => 'required|between:5,20',
            'descricao' => 'required|between:5,100',
        ]);

        if ($validator->fails()) {
            $errors = implode(', ', $validator->errors()->all());
            return $this->sendError('Erros encontrados. Verifique as informações e ' .
                'tente novamente! Detalhes: [' . $errors . ']', 400);
        }

        if (!$unidade->fill($request->all())->save()) {
            return $this->sendError('Erro ao atualizar informações do cadastro', 400);
        }
        return $this->sendResponse($unidade->toArray(), 'Informação atualizada com sucesso');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $unidade = Unidade::create($input);
        $ret = route("unidade.editar", $unidade->id);
        return $this->sendResponse(null, 'Cadastrado criado com sucesso', $ret);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $unidade_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($unidade_id)
    {
        if (!$unidade = Unidade::find($unidade_id)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        if (!$unidade->delete()) {
            return $this->sendError('Erro ao excluir cadastro', 400);
        }

        return $this->sendResponse(null, 'Exclusão efetuada com sucesso');
    }
}