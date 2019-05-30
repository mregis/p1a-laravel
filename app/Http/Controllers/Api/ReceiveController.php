<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Leitura;
use App\Models\Lote;
use App\Models\Profile;
use App\Models\Unidade;
use App\Models\Users;
use App\Models\Files;
use App\Models\Docs;
use App\Models\DocsHistory;
use App\Models\Seal;
use App\Models\SealGroup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

use Auth;

class ReceiveController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('receive.receive', compact('menus'));
    }

    /**
     * @param $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function fileList($user_id)
    {

        if (!$user = Users::find($user_id)) {
            return response()->json('Ocorreu um erro ao validar o acesso ao conteúdo.', 400);
        }
        $query = Files::query()
            ->select(
                [
                    "files.id", "files.name", "files.created_at", "files.movimento",
                    DB::raw("sum(CASE WHEN docs.status = 'pendentes' THEN 1 ELSE 0 END) as pendentes"),
                    DB::raw('count(DISTINCT docs.id) as total'),
                ])
            ->join("docs",
                function ($join) use ($user) {
                    $join->on("files.id", '=', "docs.file_id");
                    if (!in_array($user->profile, ['ADMINISTRADOR', 'DEPARTAMENTO'])) {
                        $join->where("docs.to_agency", "=", sprintf("%04d", $user->juncao));
                    }
                }
            )
            ->groupBy(["files.id", "files.name", "files.created_at", "files.movimento"]);

        return Datatables::of($query)
            ->addColumn('view', function ($file) {
                return '<a href="/receber/' . $file->id . '" title="Exibir detalhes" ' .
                'class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only">' .
                '<i class="fas fa-eye"></a>';
            })
            ->editColumn('created_at', function ($file) {
                return $file->created_at ? with(new Carbon($file->created_at))->format('d/m/Y') : '';
            })
            ->editColumn('movimento', function ($file) {
                return with(new Carbon($file->movimento))->format('d/m/Y');
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function _list(Request $request, $id)
    {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('receive.receive_list', compact('menus', 'id'));
    }

    public function arquivos(Request $request)
    {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('upload.upload_list', compact('menus'));
    }

    public function arquivo(Request $request, $id)
    {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('upload.upload_edit', compact('menus', 'id'));
    }

    public function removearquivo(Request $request, $id)
    {
        $menu = new Menu();
        $menus = $menu->menu();
//        return view('upload.upload_list', compact('menus'));
    }

    /**
     * @param $id
     * @param $profile
     * @param bool|false $juncao
     * @return \Illuminate\Http\JsonResponse
     */
    public function docs($id, $profile, $juncao = false)
    {
        if (!$file = Files::find($id)) {
            return response()->json('Não foi possível recuperar as informações requisitadas', 400);
        }

        $query = Docs::query()
            ->select("docs.*", "files.constante as constante")
            ->join("files", "docs.file_id", "=", "files.id")
            ->where("files.id", "=", $id)
            ->where(function ($query) {
                $query->whereNotIn('docs.status', ['recebido'])
                    ->orWhere('docs.status', '=', null);
            }
            );

        if ($profile != 'ADMINISTRADOR') {
            $query->where(
                function ($query) use ($juncao) {
                    $query->orWhere(function ($query) use ($juncao) {
                        $query->where([
                            ['files.constante', '=', 'DM'],
                            ['docs.to_agency', '=', sprintf("%04d", $juncao)]
                        ]);
                    })
                        ->orWhere(function ($query) use ($juncao) {
                            $query->where([
                                ['files.constante', '=', 'DA'],
                                ['docs.from_agency', '=', sprintf("%04d", $juncao)]
                            ]);
                        });
                });
        }

        return Datatables::of($query)
            ->addColumn('action', function ($doc) {
                return '<input type="checkbox" name="lote[]" class="form-control form-control-sm m-input input-doc" ' .
                'value="' . $doc->id . '">';
            })
            ->addColumn('origem', function ($doc) use ($file) {
                $doc->content = trim($doc->content);
                return ($file->constante == "DM" ? "DM" : substr($doc->content, 0, 4));
            })
            ->addColumn('destino', function ($doc) use ($file) {
                $doc->content = trim($doc->content);
                return ($file->constante == "DM" ? substr($doc->content, 0, 4) : substr($doc->content, -4, 4));
            })
            ->addColumn('status', function ($doc) {
                return $doc->status ? __('status.' . $doc->status) : '-';
            })
            ->editColumn('created_at', function ($doc) {
                return $doc->created_at ? with(new Carbon($doc->created_at))->format('d/m/Y H:i') : '';
            })
            ->editColumn('updated_at', function ($doc) {
                return $doc->created_at ? with(new Carbon($doc->created_at))->format('d/m/Y H:i') : '';
            })
            ->make(true);
    }

    public function check(Request $request, $id)
    {
        $file = Docs::where('id', $id)->first();

        if (is_null($file)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $file->status = 'concluido';
        $file->user_id = Auth::user()->id;

        $file->save();
        return $this->sendResponse($file->toArray(), 'Informação atualizada com sucesso');
    }

    public function registrar(Request $request)
    {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('receive.receive_register', compact('menus'));
    }

    public function register(Request $request)
    {
        if (!$user = Users::find($request->get('user'))) {
            return response()->json('Ocorreu um erro ao verificar permissão', 404);
        }

        $params = $request->all();

        $regs = 0;
        foreach ($params['doc'] as &$doc) {
            if ($docs = Docs::find($doc)) {
                $docs->status = 'recebido';
                $docs->user_id = $user->id;
                $docs->save();
                $docsHistory = new DocsHistory();
                $docsHistory->doc_id = $doc;
                $docsHistory->description = "capa_recebida";
                $docsHistory->user_id = $params['user'];
                $docsHistory->save();
                $regs++;
            }
        }
        return response()->json(
            sprintf('%s Envelope%s Recebido%2$s', ($regs > 0 ? $regs : 'Nenhuma'), $regs > 1 ? 's' : ''), 200
        );
    }

    public function docListingIndex()
    {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('receive.receive_doclist', compact('menus', 'id'));
    }

    /**
     * @param $profile
     * @param null|int $juncao
     * @return mixed
     */
    public function doclisting($profile, $juncao = null)
    {
        $query = Docs::query()
            ->select("docs.*", "files.constante as constante")
            ->join("files", "docs.file_id", "=", "files.id");
        if ($profile != 'ADMINISTRADOR') {
            $query
                ->orWhere(function ($query) use ($juncao) {
                    $query->where([
                        ['files.constante', '=', 'DM'],
                        ['docs.from_agency', '=', sprintf("%04d", $juncao)]
                    ])
                        ->where(function ($query) {
                            $query->whereNotIn('status', ['recebido'])
                                ->orWhere('status', '=', null);
                        });
                })
                ->orWhere(function ($query) use ($juncao) {
                    $query->where([
                        ['files.constante', '=', 'DA'],
                        ['docs.to_agency', '=', sprintf("%04d", $juncao)]
                    ])
                        ->where(function ($query) {
                            $query->whereNotIn('status', ['recebido'])
                                ->orWhere('status', '=', null);
                        });
                });

        }
        return Datatables::of($query)
            ->filterColumn('constante', function ($query, $keyword) {
                $query->where('files.constante', '=', $keyword);
            })
            ->addColumn('action', function ($doc) {
                return '<input type="checkbox" name="lote[]" class="form-control form-control-sm m-input input-doc" ' .
                'value="' . $doc->id . '">';
            })
            ->addColumn('view', function ($doc) {
                return '<a data-toggle="modal" href="#capaLoteHistoryModal" data-dochistory-id="' . $doc->id .
                '" data-dochistory-content="' . $doc->content . '" title="Histórico" ' .
                'class="btn btn-sm btn-outline-primary m-btn m-btn--icon m-btn--icon-only">' .
                '<i class="fas fa-eye"></i></a>';
            })
            ->addColumn('origin', function ($doc) {
                if ($doc->origin != null) {
                    return '<a href="javascript:void(0);" title="' . $doc->origin . '" data-toggle="tooltip">' .
                    $doc->from_agency . '</a>';
                } else {
                    return $doc->from_agency;
                }
            })
            ->addColumn('destin', function ($doc) {
                if ($doc->destin != null) {
                    return '<a href="javascript:void(0);" title="' . $doc->destin . '" data-toggle="tooltip">' .
                    $doc->to_agency . '</a>';
                } else {
                    return $doc->to_agency;
                }
            })
            ->editColumn('constante', function ($doc) {
                $doc->content = trim($doc->content);
                return ($doc->constante == "DM" ? "Devolução Matriz" : "Devolução Agência");
            })
            ->editColumn('status', function ($doc) {
                return $doc->status ? __('status.' . $doc->status) : '-';

            })
            ->editColumn('updated_at', function ($doc) {
                return $doc->updated_at ? with(new Carbon($doc->updated_at))->format('d/m/Y H:i') : '';
            })
            ->editColumn('created_at', function ($doc) {
                return $doc->created_at ? with(new Carbon($doc->created_at))->format('d/m/Y') : '';
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkCapaLote(Request $request)
    {
        $in_transaction = false;
        try {
            if (!$capaLote = $request->get('capaLote')) {
                throw new \Exception("Necessário informar uma Capa de Lote");
            }
            if (!$_lote = $request->get('lote')) {
                throw new \Exception("Necessário informar um Lote");
            }

            $user_id = $request->get('_u', 0);
            if (!$user = Users::find($user_id)) {
                throw new \Exception("Erro ao verificar permissões");
            }

            if (!in_array($user->profile, [Profile::ADMIN, Profile::OPERATOR])) {
                throw new \Exception("Você não tem permissão para executar esta ação");
            }

            if (!$unidade = Unidade::where('nome', trim($user->unidade))->first()) {
                throw new \Exception("O seu cadastro não permite executar esta ação!");
            }
            DB::beginTransaction();
            $in_transaction = true;

            $q_leitura = Leitura::query()
                ->select(["leituras.id"])
                ->join('lotes', 'leituras.lote_id', '=', 'lotes.id')
                ->where([
                    ['leituras.capalote', '=', $capaLote],
                    ['lotes.num_lote', '=', $_lote]
                ]);
            if (!$leitura = $q_leitura->first()) {
                if (!$lote = Lote::where('num_lote', $_lote)->first()) {
                    $lote = new Lote([
                        'user_id' => $user_id,
                        'unidade_id' => $unidade->id,
                        'num_lote' => $_lote,
                    ]);
                    $lote->save();
                }
                $leitura = new Leitura([
                    'user_id' => $user_id,
                    'lote_id' => $lote->id,
                    'capalote' => $capaLote,
                ]);
            } else {
                throw new \Exception(
                    sprintf("A Capa de Lote [%s] já foi lida para este Lote", $capaLote)
                );
            }

            // Nova Leitura para Lote atual
            if ($doc = Docs::where('content', $capaLote)->first()) {
                $leitura->fill(['presente' => true]);
                $response = $this->sendResponse([], 'Capa de Lote encontrada', 200);
            } else {
                $leitura->fill(['presente' => false]);
                $response = $this->sendError(sprintf('Capa de Lote inexistente [%s]', $capaLote), 400);
            }
            $leitura->save();
            DB::commit();
            $in_transaction = false;
            return $response;
        } catch (\Exception $e) {
            if ($in_transaction == true) {
                DB::rollBack();
            }
            return $this->sendError($e->getMessage(), 400);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeLeitura(Request $request)
    {
        $capaLote = $request->get('capaLote', 0);
        $_lote = $request->get('lote', 0);
        $user_id = $request->get('_u', 0);
        $_leituras = $request->get('leituras', []);
        if (!$user = Users::find($user_id)) {
            throw new \Exception("Erro ao verificar permissões");
        }

        if (!in_array($user->profile, [Profile::ADMIN, Profile::OPERATOR])) {
            throw new \Exception("Você não tem permissão para executar esta ação");
        }

        if (!$unidade = Unidade::where('nome', trim($user->unidade))->first()) {
            throw new \Exception("O seu cadastro não permite executar esta ação!");
        }

        $removed = [];
        $q_leitura = Leitura::query()
            ->select(["leituras.id", "leituras.capalote"])
            ->join('lotes', 'leituras.lote_id', '=', 'lotes.id')
            ->where([
                ['leituras.capalote', '=', $capaLote],
                ['lotes.num_lote', '=', $_lote]
            ]);
        if ($leitura = $q_leitura->first()) {
            $leitura->forceDelete();
            $removed[] = $leitura->capalote;
        } elseif (count($_leituras) > 0 && ($leituras = Leitura::whereIn('id', $_leituras)->get())) {
            foreach ($leituras as $leitura) {
                $leitura->forceDelete();
                $removed[] = $leitura->capalote;
            }
        }
        foreach (Lote::has('leituras', '<', 1)->withTrashed()->get() as $lote) {
            $lote->forceDelete();
        }

        return $this->sendResponse($removed, 'Leitura removida', 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function carregarLeituras(Request $request)
    {
        try {
            $_lote = $request->get('lote');
            $user_id = $request->get('_u', 0);
            if (!$user = Users::find($user_id)) {
                throw new \Exception("Erro ao verificar permissões");
            }
            if (!in_array($user->profile, [Profile::ADMIN, Profile::OPERATOR])) {
                throw new \Exception("Você não tem permissão para executar esta ação");
            }
            if (!$unidade = Unidade::where('nome', trim($user->unidade))->first()) {
                throw new \Exception("O seu cadastro não permite executar esta ação!");
            }

            // Verificar se essa leitura já não foi feita para esse lote
            if (!$lote = Lote::where('num_lote', $_lote)->first()) {
                throw new \Exception("Lote não encontrado.");
            }

            if ($lote->situacao == Lote::STATE_CLOSED) {
                throw new \Exception("Este Lote já foi marcado como Finalizado. \n" .
                    "Você pode verificar as leituras efetuadas na guia Leituras \n" .
                    "Não há como adicionar novas leituras a este Lote."
                );
            }

            if ($lote->unidade->nome != trim($user->unidade)) {
                throw new \Exception("Você não tem permissão para ler este lote.");
            }
            if (count($lote->leituras) > 0) {
                $msg = sprintf("Recuperado %d leitura%s para o lote %s.",
                    count($lote->leituras), (count($lote->leituras) > 1 ? "s" : ""),
                    $_lote);
                return $this->sendResponse($lote, $msg, 200);
            } else {
                throw new \Exception("Não há leituras para o Lote informado");
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 400);
        }

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function gerarNumLote()
    {
        $numLote = date('YmdHi');
        while (Lote::where('num_lote', $numLote)->first()) {
            $numLote++;
            if ($numLote > date('YmdHi') + 60) { // Somente 60 iterações
                return $this->sendError("Ocorreu um erro ao tentar gerar um novo Numero de Lote.", 400);
            }
        }
        return $this->sendResponse(['lote' => $numLote], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registeroperador(Request $request)
    {
        $in_transaction = false;
        try {
            $lacre = $request->get('lacre');
            $docs = $request->get('doc', []);
            $_lote = $request->get('lote');
            $user_id = $request->get('_u', 0);
            if (!$user = Users::find($user_id)) {
                throw new \Exception("Erro ao verificar permissões");
            }
            if (!in_array($user->profile, [Profile::ADMIN, Profile::OPERATOR])) {
                throw new \Exception("Você não tem permissão para executar esta ação");
            }
            if (!$unidade = Unidade::where('nome', trim($user->unidade))->first()) {
                throw new \Exception("O seu cadastro não permite executar esta ação!");
            }
            // Verificar se esse lote existe
            if (!$lote = Lote::where('num_lote', $_lote)->first()) {
                throw new \Exception("Lote não encontrado.");
            }
            // Tem leituras para serem incluidas...
            if (count($docs) < 1) {
                throw new \Exception('Nenhuma leitura foi informada para ser registrada.');
            }

            DB::beginTransaction();
            $in_transaction = true;

            $seal = null;
            if ($lacre != null) {
                if (!$seal = Seal::where('content', $lacre)->first()) {
                    $seal = new Seal();
                    $seal->user_id = $user_id;
                    $seal->content = $lacre;
                    $seal->save();
                }
                Leitura::where('lote_id', $lote->id)->update(['lacre' => $lacre]);
            }

            $notfound = [];
            foreach ($docs as $capaLote) {
                if ($doc = Docs::where('content', trim($capaLote))->first()) {
                    $doc->status = Docs::STATE_IN_TRANSIT;
                    $doc->user_id = $user_id;
                    $doc->save();

                    $docsHistory = new DocsHistory();
                    $docsHistory->doc_id = $doc->id;
                    $docsHistory->description = DocsHistory::STATE_IN_TRANSIT;
                    $docsHistory->user_id = $user_id;
                    $docsHistory->save();
                    if ($seal != null) {
                        if (!$sealGroup = SealGroup::where('doc_id', $doc->id)->first()) {
                            $sealGroup = new SealGroup();
                            $sealGroup->seal_id = $seal->id;
                            $sealGroup->doc_id = $doc->id;
                            $sealGroup->save();
                        }
                    }
                } else {
                    $notfound[] = $capaLote;
                }
            }
            // Atualizando informações de Leitura/Lote
            $lote->situacao = Lote::STATE_CLOSED;
            $lote->lacre = $lacre;
            $lote->save();

            ($msg = "Informação atualizada com sucesso!") &&
            (count($notfound) > 0) && ($msg .= "\n\nAtenção!\n" .
                "As seguintes Capas de Lote não foram encontradas:\n[" . implode("], [", $notfound) . "]");
            DB::commit();
            $in_transaction = false;

            return $this->sendResponse([], $msg, 200);
        } catch (\Exception $e) {
            ($in_transaction == true) && DB::rollBack();
            return $this->sendError($e->getMessage(), 400);
        }
    }


    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function listLotes(Request $request)
    {
        try {
            $user_id = $request->get('_u', 0);
            if (!$user = Users::find($user_id)) {
                throw new \Exception("Erro ao verificar permissões");
            }
            if (!$unidade = Unidade::where('nome', trim($user->unidade))->first()) {
                throw new \Exception("O seu cadastro não permite executar esta ação!");
            }

            $query = Lote::query()
                ->select([
                    "lotes.num_lote as num_lote",
                    "lotes.situacao as situacao",
                    "lotes.unidade_id as unidade_id",
                    "lotes.user_id as user_id",
                    "lotes.lacre as lacre",
                    "lotes.situacao as situacao",
                    "lotes.created_at as created_at",
                    DB::raw("COUNT(leituras.*) as leituras_count"),
                    DB::raw("SUM(CASE WHEN leituras.presente = false THEN 1 ELSE 0 END) as invalidas_count")
                ])
                ->join("leituras", "lotes.id", "=", "leituras.lote_id")
                ->groupBy(["lotes.num_lote", "lotes.situacao", "lotes.unidade_id", "lotes.user_id",
                    "lotes.lacre", "lotes.situacao", "lotes.created_at"])
            ;

            return Datatables::of($query)
                ->addColumn('action', function ($lote) use ($unidade) {
                    $return = '';
                    if ($lote->unidade_id == $unidade->id) {
                        $return = '<a href="javascript:filtrarLeituras(\'' . $lote->num_lote .
                            '\');" class="btn btn-sm btn-info mr-2" ' .
                            'title="verificar as Leituras desse Lote"><i class="fas fa-search"></i></a>';
                        if ($lote->situacao == Lote::STATE_OPEN) {
                            $return .= '<a href="javascript:carregarLeituras(\'' . $lote->num_lote . '\');" ' .
                            'class="btn btn-sm btn-success mr-2" title="Carregar Leituras"> ' .
                                '<i class="fas fa-tasks"></i></a>';
                        }
                    }
                    return $return;
                })
                ->addColumn('usuario', function ($lote) {
                    return $lote->user->name;
                })
                ->addColumn('unidade', function ($lote) {
                    return $lote->unidade->nome;
                })
                ->editColumn('lacre', function ($lote) {
                    return $lote->lacre ? $lote->lacre : '-';
                })
                ->editColumn('situacao', function ($lote) {
                    return $lote->situacao ? __('status.' . $lote->situacao) : '-';
                })
                ->editColumn('created_at', function ($lote) {
                    return $lote->created_at ? with(new Carbon($lote->created_at))->format('d/m/Y H:i') : '';
                })
                ->escapeColumns([])
                ->make(true);

        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 400);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function listLeituras(Request $request)
    {
        try {
            $user_id = $request->get('_u', 0);
            if (!$user = Users::find($user_id)) {
                throw new \Exception("Erro ao verificar permissões");
            }
            if (!$unidade = Unidade::where('nome', trim($user->unidade))->first()) {
                throw new \Exception("O seu cadastro não permite executar esta ação!");
            }
            $query = Leitura::query()
                ->select([
                    "leituras.*",
                    "lotes.num_lote as num_lote",
                    "lotes.situacao as situacao",
                    "lotes.unidade_id as unidade_id",
                    "users.name as usuario",
                ])
                ->join("lotes", "leituras.lote_id", "=", "lotes.id")
                ->join("users", "lotes.user_id", "=", "users.id")
                ;

            return Datatables::of($query)
                ->filterColumn('num_lote', function ($query, $keyword) {
                    $query->orWhere('lotes.num_lote', '=', (int)$keyword );
                })
                ->filterColumn('usuario', function ($query, $keyword) {
                    $query->orWhere('users.name', 'LIKE', '%'. $keyword . '%');
                })
                ->addColumn('action', function ($leitura) use ($unidade) {
                    $return = '';
                    if ($leitura->lote->unidade_id == $unidade->id &&
                        $leitura->lote->situacao == Lote::STATE_OPEN) {
                        $return = sprintf('<input type="checkbox" name="leitura[]" value="%d" class="input-leitura">', $leitura->id);
                    }
                    return $return;

                })
                ->addColumn('situacao', function ($leitura) {
                    return $leitura->presente ? 'Presente' : 'Ausente';
                })
                ->editColumn('created_at', function ($leitura) {
                    return $leitura->created_at ? with(new Carbon($leitura->created_at))->format('d/m/Y H:i') : '';
                })
                ->addColumn('buttons', function ($leitura) use ($unidade) {
                    $return = '';
                    if ($leitura->unidade_id == $unidade->id &&
                        $leitura->situacao == Lote::STATE_OPEN) {
                        $return = '<a href="javascript:;" onclick="removeUmaLeitura($(this));" ' .
                        'class="btn btn-sm btn-danger btn-remove-leitura" ' .
                            'title="Remover leitura"><i class="fas fa-times"></i></a>';
                    }
                    return $return;
                })
                ->escapeColumns([])
                ->make(true);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 400);
        }
    }

    /**
     * @param Request $request
     */
    public function carregarArquivoLeituras(Request $request)
    {
        $in_transaction = false;
        try {
            $user_id = $request->get('_u', 0);
            if (!$user = Users::find($user_id)) {
                throw new \Exception("Erro ao verificar permissões");
            }
            if (!in_array($user->profile, [Profile::ADMIN, Profile::OPERATOR])) {
                throw new \Exception("Você não tem permissão para executar esta ação");
            }
            if (!$unidade = Unidade::where('nome', trim($user->unidade))->first()) {
                throw new \Exception("O seu cadastro não permite executar esta ação!");
            }

            if (!$lotes = $request->get('lotes')) {
                throw new \Exception("Não há leituras para serem registradas");
            }

            $in_transaction = true;
            DB::beginTransaction();
            $seal = $msg = null;
            $cntr = 0; // Contador de leituras efetuadas
            foreach ($lotes as $id_lote) {
                if ($lote = Lote::find($id_lote)) {
                    if ($lote->situacao == Lote::STATE_OPEN) {
                        // Verificando Lacre
                        if ($lote->lacre != null) {
                            if (!$seal = Seal::where('content', $lote->lacre)->first()) {
                                $seal = new Seal();
                                $seal->user_id = $user_id;
                                $seal->content = $lote->lacre;
                                $seal->save();
                            }
                        }

                        foreach ($lote->leituras as $leitura) {
                            if ($doc = Docs::where('content', trim($leitura->capalote))->first()) {
                                if (in_array($doc->status,
                                    [Docs::STATE_IN_TRANSIT, Docs::STATE_CONTINGENCY, Docs::STATE_PENDING, Docs::STATE_SENT])
                                ) {
                                    $doc->status = Docs::STATE_IN_TRANSIT;
                                    $doc->user_id = $user_id;
                                    $doc->save();
                                }
                                $docsHistory = new DocsHistory();
                                $docsHistory->doc_id = $doc->id;
                                $docsHistory->description = DocsHistory::STATE_IN_TRANSIT;
                                $docsHistory->user_id = $user_id;
                                $docsHistory->save();
                                if ($seal != null) {
                                    if (!$sealGroup = SealGroup::where('doc_id', $doc->id)->first()) {
                                        $sealGroup = new SealGroup();
                                        $sealGroup->seal_id = $seal->id;
                                        $sealGroup->doc_id = $doc->id;
                                        $sealGroup->save();
                                    }
                                }
                                $cntr++;
                            }
                        }
                        // Atualizando informações de Leitura/Lote
                        $lote->situacao = Lote::STATE_CLOSED;
                        $lote->save();
                    }
                }
            }


            DB::commit();
            $in_transaction = false;
            (($cntr == 0) && ($msg = ' Nenhuma leitura nova efetuada')) ||
            (($cntr == 1) && ($msg = ' 1 leitura nova efetuada')) ||
            (($cntr > 1) && ($msg = sprintf(' %d leituras novas efetuadas', $cntr)));

            return $this->sendResponse([], 'Arquivo carregado.' . $msg, 200);

        } catch (\Exception $e) {
            if ($in_transaction) {
                DB::rollBack();
            }
            return $this->sendError($e->getMessage(), 400);
        }
    }

    public function lerArquivoLeituras(Request $request) {
        $in_transaction = true;
        try {
            $user_id = $request->get('_u', 0);
            if (!$user = Users::find($user_id)) {
                throw new \Exception("Erro ao verificar permissões");
            }
            if (!in_array($user->profile, [Profile::ADMIN, Profile::OPERATOR])) {
                throw new \Exception("Você não tem permissão para executar esta ação");
            }
            if ($user->profile == Profile::ADMIN) {
                if ((!$unidade_id = $request->get('unidade')) || (!$unidade = Unidade::find($unidade_id))) {
                    throw new \Exception("Valor para o campo Unidade Leitura inválido!");
                }

            } elseif (!$unidade = Unidade::where('nome', trim($user->unidade))->first()) {
                throw new \Exception("O seu cadastro não permite executar esta ação!");
            }
            // Validando campos obrigatórios
            if (!$dt_leitura = $request->get('dt_leitura')) {
                throw new \Exception("Valor para o campo Data de Leitura inválido!");
            }

            $dt_leitura = new \DateTime(str_replace("/", "-", $dt_leitura));
            $_lacre = $request->get('_lacre');
            // Verificando o arquivo carregado
            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $file_hash = hash_file('crc32b', $request->file->getPathName());
                if (($handle = fopen($request->file->getPathName(), 'r')) !== FALSE) {
                    $i = 1;
                    $rows = [];
                    while (!feof($handle)) {
                        $r = trim(fgets($handle));
                        if ($r == '') continue; // Evitar linhas em branco
                        if (strlen($r) < 13 || !is_numeric($r)) { // Linhas com menos de 6 caracteres são considerados erros
                            fclose($handle);
                            throw new \Exception(
                                sprintf('Registro [%s] da linha %d é inválido. Processo interrompido', $r, $i)
                            );
                        }
                        $rows[] = $r;
                        $i++;
                    }
                    fclose($handle);
                } else {
                    throw new \Exception('Erro ao ler arquivo.');
                }
                if (count($rows) < 1) {
                    throw new \Exception('Arquivo não contém registros');
                }
                // Verificando se esse arquivo já não foi carregado
                $id_lotes = [];
                $response = [];

                if ($lotes = Lote::query()
                    ->select([
                        "lotes.id as id",
                        "lotes.num_lote as num_lote",
                        "lotes.situacao as situacao",
                        "lotes.unidade_id as unidade_id",
                        "lotes.user_id as user_id",
                        "lotes.lacre as lacre",
                        "lotes.situacao as situacao",
                        "lotes.created_at as created_at",
                        DB::raw("COUNT(leituras.*) as leituras_count"),
                        DB::raw("SUM(CASE WHEN leituras.presente = false THEN 1 ELSE 0 END) as leituras_ausentes_count")
                    ])
                    ->join("leituras", "lotes.id", "=", "leituras.lote_id")
                    ->where('file_hash', $file_hash)
                    ->groupBy(["lotes.id", "lotes.num_lote", "lotes.situacao", "lotes.unidade_id", "lotes.user_id",
                        "lotes.lacre", "lotes.situacao", "lotes.created_at"])
                    ->get()) {
                    $t = $a = 0;
                    foreach ($lotes as $l) {
                        $t += $l->leituras_count;
                        $a += $l->leituras_ausentes_count;
                        $response[$l->num_lote] = [
                            'c' => $l->num_lote,
                            'i' => $l->id,
                            'p' => $l->leituras_count - $l->leituras_ausentes_count,
                            'a' => $l->leituras_ausentes_count,
                            's' => $l->situacao,
                            't' => sprintf("Lote %s criado. %d leituras registradas. %d presentes e %d ausentes.",
                                $l->num_lote,$l->leituras_count,
                                $l->leituras_count - $l->leituras_ausentes_count,
                                $l->leituras_ausentes_count),
                        ];
                        $id_lotes[] = $l->id;
                    }
                    if ($t >= count($rows)) {
                        return $this->sendResponse($response, 'Este arquivo já foi carregado anteriormente! '.
                            'Verifique a situação de cada lote gerado na lista de Lotes. Se preferir, ' .
                            'as leituras podem ser gerenciadas acessando a aba [Lotes de Leitura] ' .
                            'no item de menu [Recebimento -> Operador]');
                    }
                }
                set_time_limit(120);
                DB::beginTransaction();
                $msg = null;
                // Verificando Lacre
                if ($_lacre != null) {
                    if (!$seal = Seal::where('content', $_lacre)->first()) {
                        $seal = new Seal();
                        $seal->user_id = $user_id;
                        $seal->content = $_lacre;
                        $seal->save();
                    }
                }

                $_lote = $dt_leitura->format('YmdHi');
                while ($lote = Lote::where('num_lote', $_lote)->first()) {
                    $_lote++;
                    if ((int)$dt_leitura->format('YmdHi') + 60 < $_lote) {
                        throw new \Exception('Ocorreu um erro ao tentar gerar um lote para as leituras do arquivo');
                    }
                }
                $lote = Lote::create([
                    'user_id' => $user_id,
                    'unidade_id' => $unidade->id,
                    'num_lote' => $_lote,
                    'created_at' => $dt_leitura,
                    'lacre' => $_lacre,
                    'file_hash' => $file_hash
                ]);

                $presentes = $ausentes = 0;
                foreach ($rows as $k => $capaLote) {
                    if (count($id_lotes) < 1 || !$leitura = Leitura::where('capalote', $capaLote)
                        ->whereIn('lote_id', $id_lotes)->first()) {
                        $leitura = new Leitura([
                            'user_id' => $user_id,
                            'lote_id' => $lote->id,
                            'capalote' => $capaLote,
                            'lacre' => $_lacre,
                            'dt_leitura' => $dt_leitura
                        ]);
                        // Nova Leitura para Lote atual
                        if ($doc = Docs::where('content', $capaLote)->first()) {
                            $leitura->fill(['presente' => true]);
                        } else {
                            $leitura->fill(['presente' => false]);

                        }
                        if (!$leitura->save()) {
                            throw new \Exception(
                                sprintf("Ocorreu um erro ao tentar registrar a leitura da capa de " .
                                    "lote [%s] presente na linha [%d]", $capaLote, $k + 1)
                            );
                        }
                    }
                    if ($leitura->presente == true) {
                        $presentes++;
                    } else {
                        $ausentes++;
                    }

                    $response[$_lote] = [
                        'c' => $_lote,
                        'i' => $lote->id,
                        'p' => $presentes,
                        'a' => $ausentes,
                        's' => $lote->situacao,
                    ];

                    if ($k % 500 == 0 && $k > 1) {
                        $presentes = $ausentes = 0;
                        $_lote++;
                        while ($lote = Lote::where('num_lote', $_lote)->first()) {
                            $_lote++;
                            if ((int)$dt_leitura->format('YmdHi') + 60 < $_lote) {
                                throw new \Exception('Ocorreu um erro ao tentar gerar um lote para as leituras do arquivo');
                            }
                        }
                        $lote = Lote::create([
                            'user_id' => $user_id,
                            'unidade_id' => $unidade->id,
                            'num_lote' => $_lote,
                            'created_at' => $dt_leitura,
                            'lacre' => $_lacre,
                            'file_hash' => $file_hash,
                        ]);
                    }
                }

                foreach ($response as $c => $lote) {
                    $lote['t'] = sprintf("Lote %s criado. %d leituras registradas. %d presentes e %d ausentes.", $c,
                        ($lote['p'] + $lote['a']),$lote['p'], $lote['a']);
                }
                DB::commit();
                $in_transaction = false;
                return $this->sendResponse($response, 'Arquivo carregado.');
            } else {
                throw new \Exception('Arquivo inválido.');
            }
        } catch (\Exception $e) {
            if ($in_transaction == true) {
                DB::rollBack();
            }
            return $this->sendError($e->getMessage(), 400);
        }
    }
}
