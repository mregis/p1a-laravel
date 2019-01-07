<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 10/12/2018
 * Time: 23:37
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Agencia;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Request;
use Yajra\DataTables\DataTables;
use DB;
use Validator;

class AgenciasController extends Controller
{

    public function _list() 
    {
        $query = Agencia::query();
        return DataTables::of($query)
            ->addColumn('action', function ($agencia) {
                return '<div align="center"><a href="' . route('agencias.editar', $agencia->id) .
                '" data-toggle="tooltip" title="Editar" ' .
                'class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only">' .
                '<i class="fas fa-edit"></i></a><button onclick="actionAjax(\'' .
                route('agencias.api-remover', $agencia->id) . '\',\'delete\')"' .
                'data-toggle="tooltip" title="Excluir" ' .
                'class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only">' .
                '<i class="fas fa-trash-alt"></i></button></div>';
            })
            ->addColumn('cidade_uf', function ($agencia) {
                return sprintf("%s/%s", $agencia->cidade, $agencia->uf);
            })
            ->addColumn('cep', function ($agencia) {
                return preg_replace('#(\d{5})-?(\d{3})#', '$1-$2', $agencia->cep);
            })
            ->editColumn('updated_at', function ($agencia) {
                return $agencia->updated_at ? with(new Carbon($agencia->updated_at))->format('d/m/Y H:i') : '';
            })
            ->editColumn('created_at', function ($agencia) {
                return $agencia->created_at? with(new Carbon($agencia->created_at))->format('d/m/Y H:i') : '';
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * @param Request $request
     * @param $agencia_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $agencia_id)
    {
        if (!$agencia = Agencia::find($agencia_id)) {
            return response()->json('Informação não encontrada', 404);
        }
        if ($request->get('_u') == null || !$user = Users::find($request->get('_u'))) {
            return response()->json('Erro ao verificar permissão', 404);
        }
        if ($user->profile != 'ADMINISTRADOR' && $user->profile != 'DEPARTAMENTO') {
            return response()->json('Sem permissão para executar operação', 404);
        }

        $validator = Validator::make($request->all(), [
            'codigo' => 'required|digits:4|not_in:0000',
            'nome' => 'required|between:5,100',
            'cd' => 'required',
            'cep' => 'required|between:8,9|not_in:00000000,00000-000',
            'endereco' => 'required|between:5,100',
            'uf' => 'required|in:SP,RJ,MG,RS,AC,AL,AM,AP,BA,CE,DF,ES,GO,MA,MT,MS,PA,PB,PR,PE,PI,RN,RO,RR,SC,SE,TO',
            'cidade' => 'required|between:5,100',
            'bairro' => 'nullable|between:5,100',
        ]);

        if ($validator->fails()) {
            $errors = implode(', ', $validator->errors()->all());
            return response()->json('Erros encontrados. Verifique as informações e ' .
                'tente novamente! Detalhes: [' . $errors . ']', 400);
        }


        if ($agencia->fill($request->all())->save()) {
            Audit::create([
                'description' => sprintf('Cadastro Agencia [%s] atualizado', $agencia->codigo),
                'user_id' => $user->id
            ]);
        } else {
            return response()->json('Erro ao excluir cadastro', 400);
        }

        return response()->json('Informação atualizada com sucesso', 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $agencia = Agencia::create($input);
        return response()->json('Cadastrado criado com sucesso', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $agencia_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($agencia_id)
    {
        if (!$agencia = Agencia::find($agencia_id)) {
            return response()->json('Informação não encontrada', 404);
        }

        if (!$agencia->delete()) {
            return response()->json('Erro ao excluir cadastro', 400);
        }

        return response()->json('Exclusão efetuada!', 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function prefetchList(Request $request)
    {
        $agencias = [];
        if ($request->get('q') != null) {
            $limit = max((int)$request->get('l', 10), 1);
            $agencias = Agencia::query()
                ->where('codigo', '=', $request->get('q'))
                ->orWhere('nome', '=', $request->get('q'))
                ->limit($limit)
                ->get();
        }
        return response()->json($agencias, 200);
    }
}