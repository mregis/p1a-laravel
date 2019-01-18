<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Agencia;
use App\Models\Profile;
use App\Models\Unidade;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use Hash;
use Validator;
use Auth;
use App\Models\Audit;

class UsersController extends BaseController
{
    /**
     * @param Request $request
     * @param $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function listUsers(Request $request, $user_id)
    {
        if (!$user = Users::find($user_id)) {
            return $this->sendError('Erro ao recuperar informações', 404);
        }

        if (!in_array($user->profile, ["ADMINISTRADOR", "DEPARTAMENTO"])) {
            return $this->sendError('Recurso não encontrado', 404);
        }

        $query = Users::query();

        if ($user->profile != "ADMINISTRADOR") {
            $query->where('profile', 'AGÊNCIA');
        }

        return Datatables::of($query)
            ->addColumn('action', function ($user) {
                return '<div align="center"><a href="edit/' . $user->id .
                    '" data-toggle="tooltip" title="Editar" ' .
                    'class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only">' .
                    '<i class="fas fa-edit"></i></a>' .
                    '<button onclick="modalDelete(' . $user->id . ')"' .
                    'data-toggle="tooltip" title="Excluir" ' .
                    'class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only">' .
                    '<i class="fas fa-trash-alt"></i></button></div>';
            })
            ->editColumn('last_login', function ($user) {
                return $user->last_login ? with(new Carbon($user->last_login))->format('d/m/Y H:i') : 'Nunca';
            })
            ->editColumn('created_at', function ($user) {
                return $user->created_at ? with(new Carbon($user->created_at))->format('d/m/Y H:i') : null;
            })
            ->editColumn('updated_at', function ($user) {
                return $user->updated_at ? with(new Carbon($user->updated_at))->format('d/m/Y H:i') : '';
            })
            ->editColumn('juncao', function ($user) {
                if ($agencia = $user->agencia) {
                    return (string) $agencia;
                }
                return '-';
            })
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
	    $input['password'] = Hash::make($input['password']);
        $user = Users::create($input);
        $ret = "/users/" . $user->id;
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
        if (!$user = Users::find($id)) {
            return $this->sendError('Informação não encontrada', 404);
        }
        return $this->sendResponse($user->toArray(), 'Informação recuperada com sucesso');
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
        if (!$user = Users::find($id)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        if ($request->get('_u') == null || !$auth = Users::find($request->get('_u'))) {
            return $this->sendError('Erro ao verificar permissão', 404);
        }

        if ($auth->profile != 'ADMINISTRADOR' && $auth->profile != 'DEPARTAMENTO') {
            return $this->sendError('Sem permissão para executar operação', 404);
        }

        $user_data = $request->all();
        $validator = Validator::make($user_data, [
            'name' => 'required|between:5,100',
            'password' => 'nullable|confirmed',
            'profile' => 'required',
        ]);

        $validator->after(function ($validator) use (&$user_data) {
            // check Profile
            if (!$profile = Profile::where('nome', $user_data['profile'])->first()
            ) {
                $validator->errors()->add('profile',
                    'Perfil inválido! Verifique as informações. Persistindo o problema contate o Administrador');
            }
            // If the user has profile is AGÊNCIA
            if ($profile->nome == 'AGÊNCIA') {
                $juncao = preg_replace('#^(\d+):.*?$#', '$1', $user_data['juncao']);
                if (!$agencia = Agencia::where('codigo', $juncao)->first()) {
                    $validator->errors()->add('juncao', 'Obrigatório indicar uma Agência válida para o perfil indicado!');
                }
                $user_data['juncao'] = $juncao;
                $user_data['unidade'] = null;
            } elseif ($profile->nome == 'OPERADOR') { // If the user has profile is OPERADOR
                if (!$unidade = Unidade::where('nome', $user_data['unidade'])->first()) {
                    $validator->errors()->add('unidade', 'Obrigatório indicar uma Unidade válida para o perfil indicado!');
                }
                $user_data['juncao'] = null;
            }
        });

        if ($validator->fails()) {
            $errors = implode(', ', $validator->errors()->all());
            return $this->sendError('Erros encontrados. Verifique as informações e ' .
                'tente novamente! Detalhes: [' . $errors . ']', 400);
        }
        if ($user_data['password'] == null) {
            unset($user_data['password']);
        } else {
            $user_data['password'] = Hash::make($user_data['password']);
        }

        if ($user->fill($user_data)->save()) {
            Audit::create([
                'description' => sprintf('Cadastro Usuario [%s] atualizado', $user->name),
                'user_id' => $auth->id
            ]);
        } else {
            return $this->sendError('Erro ao atualizar cadastro', 400);
        }
        return $this->sendResponse(null, 'Informação atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$user = Users::find($id)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        if ($user->delete()) {
            Audit::create([
                'description' => sprintf('Usuario [%s] removido', $user->name),
                'user_id' => Auth::id()
            ]);
        } else {
            return $this->sendError('Erro ao excluir cadastro', 400);
        }
        return $this->sendResponse(null, 'Exclusão efetuada com sucesso');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function updateMyProfile(Request $request)
    {
        $user_data = $request->all();

        $validator = Validator::make($user_data, [
            'password' => 'nullable|confirmed',
        ]);

        if ($validator->fails()) {
            $errors = implode(', ', $validator->errors()->all());
            return $this->sendError('Erros encontrados. Verifique as informações e ' .
                'tente novamente! Detalhes: [' . $errors . ']', 400);
        }

        if ($user_data['password'] == null) {
            unset($user_data['password']);
        } else {
            $user_data['password'] = Hash::make($user_data['password']);
        }

        $user_data['last_login'] = new \DateTime();
        if (!$user = Users::find($user_data['_u'])) {
            return $this->sendError('Informação não encontrada', 404);
        }

        if ($user->fill($user_data)->save()) {
            Audit::create([
                'description' => sprintf('Usuario [%s] atualizou senha', $user->name),
                'user_id' => $user->id
            ]);
        } else {
            return $this->sendError('Erro ao atualizar cadastro', 400);
        }

        return $this->sendResponse(null, 'Informação atualizada com sucesso');
    }
}
