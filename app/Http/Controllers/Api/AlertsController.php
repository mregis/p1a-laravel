<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Alerts;
use App\Models\Audit;
use App\Models\Docs;
use App\Models\DocsHistory;
use App\Models\Products;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AlertsController extends BaseController
{

    public function listAlerts(Request $request)
    {
        $query = Alerts::with(['user', 'product']);
        return Datatables::of($query)
            ->addColumn('action', function ($ocorrencia) {
                return sprintf('<a href="%s" data-toggle="tooltip" title="Editar" ' .
                    'class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only">' .
                    '<i class="fas fa-edit"></i></a><button onclick="modalDelete(' . $ocorrencia->id . ')" ' .
                    'data-toggle="tooltip" title="Excluir" ' .
                    'class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only">' .
                    '<i class="fas fa-trash-alt"></i></button>',
                    route('ocorrencias.edit', $ocorrencia->id));
            })
            ->editColumn('created_at', function ($ocorrencia) {
                return $ocorrencia->created_at ? with(new Carbon($ocorrencia->created_at))->format('d/m/Y H:i') : '';
            })
            ->editColumn('updated_at', function ($ocorrencia) {
                return $ocorrencia->updated_at ? with(new Carbon($ocorrencia->updated_at))->format('d/m/Y H:i') : '';
            })
            ->editColumn('description', function($ocorrencia) {
                return sprintf('<div class="text-left" style="white-space: normal"><ul><li>%s</li></ul></div>',
                    implode('</li><li>', explode("\n", $ocorrencia->description)));
            })
            ->addColumn('user.local', function($ocorrencia) {
                return $ocorrencia->user->getLocal();
            })
            ->rawColumns(['description', 'action'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('cadastros.alerts_list', compact('menus'));
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
        $input['user_id'] = $input['_u'];
        $input['product_id'] = $input['product'];
        $ocorrencia = Alerts::create($input);

        return $this->sendResponse(null, 'Cadastrado com sucesso', $ocorrencia);

    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        if (!$ocorrencia = Alerts::find($id)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        return $this->sendResponse($ocorrencia->toArray(), 'Informação recuperada com sucesso');
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

        if (!$ocorrencia = Alerts::find($id)) {
            return $this->sendError('Informação não encontrada', 404);
        }
        $input = $request->all();
        $ocorrencia->description .= "\n[" . date('d-m-Y H:i') .'] ' . $input['description'];
        $ocorrencia->save();
        return $this->sendResponse($ocorrencia->toArray(), 'Informação atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$ocorrencia = Alerts::find($id)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $ocorrencia->delete();
        return $this->sendResponse(null, 'Ocorrência excluída com sucesso');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!$ocorrencia =  Alerts::find($id)) {
            return $this->sendError('Informação não encontrada', 404);
        }
        $menu = new Menu();
        $menus = $menu->menu();
        return view('ocorrencias.alerts_list', compact('alert', 'menus'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menu = new Menu();
        $menus = $menu->menu();

        return view('alerts.alerts_add', compact('menus','permissao'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reportTheft(Request $request)
    {
        $user_id = $request->get('_u');
        if (!$user = Users::find($user_id)) {
            return $this->sendError('Este recurso não está disponível no momento', 400);
        }

        if (!in_array($user->profile, ['ADMINISTRADOR', 'DEPARTAMENTO']) ) {
            return $this->sendError('Você não tem permissão para utilizar este recurso', 400);
        }
        if ($docs = $request->get('docs')) {
            if (!$product = Products::where('description', 'ENVELOPES COMPE')->first()) {
                throw new Exception("Erro ao recuperar o produto");
            }
            $alert_data = [
                'type' => Alerts::TYPE_DOC_THEFT,
                'product_id' => $product->id,
                'user_id' => $user_id,
                'content' => 'Capa de Lote [%s] roubada',
                'description' => 'A Capa de Lote [%s] pertencente ao movimento do dia [%s] ' .
                    'proveniente de [%s] não chegou ao destino [%s] por ter sido roubada.',
            ];
            $in_transaction = false;
            DB::beginTransaction();
            try {
                $in_transaction = true;
                $cntr = 0;
                foreach ($docs as $doc_id) {
                    if ($doc = Docs::find($doc_id)) {
                        $alert = new Alerts($alert_data);
                        $alert->content = sprintf($alert->content, $doc->content);
                        $alert->description = sprintf($alert->description,
                            $doc->content, (new \DateTime($doc->file->movimento))->format('d/m/Y'),
                            $doc->origin, $doc->destin);
                        if (!$alert->save()) {
                            throw new Exception('Ocorreu um erro ao tentar criar uma ocorrência');
                        }
                        $doc->status = 'roubado';
                        if (!$doc->save()) {
                            throw new Exception('Ocorreu um erro ao alterar a situação de uma capa de Lote');
                        }
                        $docsHistory = new DocsHistory();
                        $docsHistory->doc_id = $doc->id;
                        $docsHistory->description = "capa_roubada";
                        $docsHistory->user_id = $user_id;
                        $docsHistory->save();
                        if (!$doc->save()) {
                            throw new Exception('Ocorreu um erro ao criar histórico para Capa de Lote');
                        }
                    }
                    $cntr++;
                }
                Audit::create([
                    'description' => sprintf('Reportado Roubo da[s] Capa[s] de Lote [%s]', implode(" | ", $docs)),
                    'user_id' => $user_id
                ]);
                DB::commit();
                $in_transaction = false;
                ($cntr > 0) ?
                    ($msg = sprintf('%s Capa%s de Lote reportada como roubada%2$s', $cntr, ($cntr > 1 ? 's' : ''))) :
                    ($msg = "Nenhuma capa de Lote foi reportada");

                return $this->sendResponse(null, $msg);
            } catch (\Exception $e) {
                if ($in_transaction) {
                    DB::rollBack();
                }
                return $this->sendError($e->getMessage(), 400);
            }
        }
        return $this->sendError("Nenhuma informação foi passada para executar a ação.", 400);
    }
}
