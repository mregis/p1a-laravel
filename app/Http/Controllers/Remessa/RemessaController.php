<?php

namespace App\Http\Controllers\Remessa;

use App\Http\Controllers\BaseController;
use App\Models\Profile;
use App\Models\Users;
use App\Models\Files;
use App\Models\Docs;
use App\Models\DocsHistory;
use App\Models\Seal;
use App\Models\SealGroup;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Menu;
use DB;


class RemessaController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = $request->get('_u');
        if ($request->hasFile('file')) {
            $in_transaction = false;
            try {
                if ($file = $request->file('file')->isValid()) {
                    $name = $request->file->getClientOriginalName();
                    if (!($dt_movimento = \DateTime::createFromFormat('dm.y', substr($name, 5, 7))) ||
                    $dt_movimento->format('dm.y') != substr($name, 5, 7)) {
                        throw new \Exception('A nomenclatura do arquivo é inválida!');
                    }

                    $file_hash = hash_file('crc32b', $request->file->getPathName());
                    if (Files::where('file_hash', '=', $file_hash)->first()) {
                        throw new \Exception('Arquivo já carregado anteriormente');
                    }
                    if (($handle = fopen($request->file->getPathName(), 'r')) !== FALSE) {
                        $i = 1;
                        $rows = [];
                        while (!feof($handle)) {
                            $r = trim(fgets($handle));
                            if ($r == '') continue; // Evitar linhas em branco
                            if (strlen($r) < 13 || !is_numeric($r)) { // Linhas com menos de 6 caracteres são considerados erros
                                fclose($handle);
                                throw new \Exception(
                                    sprintf('Registro [%s] da linha %d é inválido. Processo abortado', $r, $i)
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
                    DB::beginTransaction(); // Iniciando uma transação para evitar problemas com o banco
                    $in_transaction = true;
                    // Criando o registro do Arquivo
                    $oFile = new Files(
                        [
                            'name' => $name,
                            'total' => count($rows),
                            'constante' => substr($name, 0, 2),
                            'file_hash' => $file_hash,
                            'codigo' => substr($name, 2, 3),
                            'movimento' => $dt_movimento,
                            'sequencial' => substr($name, 12, 1),
                            'user_id' => $user_id,
                        ]
                    );
                    if ($oFile->save()) {
                        $cntr = 0;
                        foreach ($rows as $k => &$r) { // Qual é o intuito do programador de usar referencia num loop for
                            if (!Docs::where('content', 'like', $r)->first()) {
                                $oDoc = new Docs(
                                    [
                                        'file_id' => $oFile->id,
                                        'content' => $r,
                                        'status' => ($oFile->constante == 'DM' ? 'enviado' : 'pendente'),
                                        'from_agency' => ($oFile->constante == 'DM' ? '4510' : substr($r, 0, 4)),
                                        'to_agency' => ($oFile->constante == 'DM' ? substr($r, 0, 4) : substr($r, -4, 4)),
                                        'user_id' => $user_id,
                                    ]
                                );

                                if ($oDoc->save()) {
                                    $oHistory = new DocsHistory(
                                        [
                                            'doc_id' => $oDoc->id,
                                            'description' => "upload",
                                            'user_id' => $user_id,
                                        ]
                                    );
                                    if ($oHistory->save()) {
                                        $cntr++;
                                    } else {
                                        $oDoc->delete();
                                        $oFile->delete();
                                        throw new \Exception('Erro ao criar entrada de historico.');
                                    }
                                } else {
                                    $oFile->delete();
                                    throw new \Exception('Erro ao criar entrada de registro.');
                                }
                            }
                        }
                        $oFile->total = $cntr;
                        $oFile->save();
                    } else {
                        throw new \Exception('Erro ao carregar arquivo.');
                    }
                    (($cntr == 0) && ($msg = ' Nenhum registro novo inserido')) ||
                    (($cntr == 1) && ($msg = ' 1 registro novo inserido')) ||
                    (($cntr > 1) && ($msg = sprintf(' %d registros novos inserido', $cntr)));

                    DB::commit();
                    return $this->sendResponse([], 'Arquivo carregado.' . $msg, 200);
                }
                return $this->sendError('Arquivo não carregado', 400);// Somente com erro chega aqui
            } catch (\Exception $e) {
                if ($in_transaction == true) {
                    DB::rollback();
                }
                return $this->sendError($e->getMessage(), 400);
            }
        }

        $menu = new Menu();
        $menus = $menu->menu();
        return view('upload.upload', compact('menus'));
    }

    public function listFiles()
    {
        $query = Files::query();
        return Datatables::of($query)
            ->addColumn('action', function ($file) {
                return '<div align="center"><a href="' . route('arquivo.file', $file->id) .
                '" class="btn btn-sm btn-outline-primary m-btn m-btn--icon m-btn--icon-only mr-1">' .
                '<i class="fas fa-eye"></i></a><button onclick="modalDelete(' . $file->id . ')" ' .
                'class="btn btn-sm btn-outline-danger m-btn m-btn--icon m-btn--icon-only mr-1">' .
                '<i class="fas fa-trash-alt"></i></button></div>';
            })
            ->editColumn('created_at', function ($file) {
                return $file->created_at ? with(new Carbon($file->created_at))->format('d/m/Y H:i') : '-';
            })
            ->editColumn('updated_at', function ($file) {
                return $file->updated_at ? with(new Carbon($file->updated_at))->format('d/m/Y H:i') : '-';
            })
            ->editColumn('movimento', function ($file) {
                return with(new Carbon($file->movimento))->format('d/m/Y');
            })
            ->editColumn('total', function ($file) {
                return number_format($file->total, 0, ',', '.');
            })
            ->make(true);
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
        $files = Files::where('id', $id)->first();

        if (is_null($files)) {
            return $this->sendError('Informação não encontrada', 404);
        }
        $docs = Docs::where('file_id', $files->id);
        foreach ($docs as &$d) {
            $d->delete();
        }
        $files->delete();

        return $this->sendResponse(null, 'Informação excluída com sucesso');
    }

    public function docs(Request $request, $id, $profile, $juncao = false)
    {
        $params = array('file_id' => $id);
        $query = Docs::query()
            ->where($params);

        if ($profile != Profile::ADMIN) {
            $query = Docs::query()
                ->where([
                    ['file_id', '=', $id],
                    ['content', 'like', sprintf("%04d", $juncao) . '%'],
                ]);
        }

        return Datatables::of($query)
            ->addColumn('action', function ($doc) {
                return '';
            })
            ->editColumn('created_at', function ($doc) {
                return $doc->created_at ? with(new Carbon($doc->created_at))->format('d/m/Y H:i:s') : '';
            })
            ->editColumn('updated_at', function ($doc) {
                return $doc->created_at ? with(new Carbon($doc->created_at))->format('d/m/Y H:i:s') : '';
            })
            ->editColumn('status', function ($doc) {
                return $doc->status ? __('status.' . $doc->status) : '-';
            })
            ->make(true);
    }

    public function report(Request $request, $id, $profile, $juncao = false)
    {
        $dcs = Docs::where('file_id', $id)->get();
        $docs = array();
        foreach ($dcs as &$d) {
            $d->content = trim($d->content);
            $total_string = strlen($d->content);
            $separate = substr($d->content, ($total_string - 4), 4);
            if ($profile == Profile::AGENCY) {
                if (substr($d->content, 0, 4) == $juncao || $separate == $juncao) {
                    $docs[] = $d;
                }
            } else {
                $docs[] = $d;
            }
        }
        return Datatables::of($docs)
            ->addColumn('action', function ($docs) {
                return '<div align="center"><a data-toggle="modal" href="#capaLoteHistoryModal" onclick="getHistory(' . $docs->id . ')" title="Histórico" class="btn m-btn m-btn--icon m-btn--icon-only"><i class="fas fa-eye"></i></button></div>';
            })
            ->editColumn('created_at', function ($docs) {
                return $docs->created_at ? with(new Carbon($docs->created_at))->format('d/m/Y H:i:s') : '';
            })
            ->editColumn('updated_at', function ($docs) {
                return $docs->created_at ? with(new Carbon($docs->created_at))->format('d/m/Y H:i:s') : '';
            })
            ->editColumn('status', function ($doc) {
                return $doc->status ? __('status.' . $doc->status) : '-';
            })
            ->make(true);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if (!$file = Files::find($id)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        DB::beginTransaction();
        foreach ($file->docs as $doc) {
            $doc->delete();
        }
        $file->delete();
        DB::commit();

        return $this->sendResponse(null, 'Informação excluída com sucesso');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function registrar(Request $request)
    {
        $menus = $this->menu->menu();
        return view('remessa.registrar', compact('menus'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function register(Request $request)
    {
        try {
            if (!$user = Users::find($request->get('user'))) {
                throw new \Exception('Ocorreu um erro ao verificar permissão');
            }

            $params = $request->all();

            // Iniciando transaction
            DB::beginTransaction();
            $in_transaction = true;
            if (!$seal = Seal::where('content', $params['lacre'])->first()) {
                $seal = new Seal();
                $seal->user_id = $user->id;
                $seal->content = $params['lacre'];
                $seal->save();
            }
            $regs = 0;
            foreach ($params['doc'] as $doc_id) {
                if (!$sealGroup = SealGroup::where('doc_id', $doc_id)->first()) {
                    $sealGroup = new SealGroup();
                    $sealGroup->seal_id = $seal->id;
                    $sealGroup->doc_id = $doc_id;
                    $sealGroup->save();
                }
                if ($doc = Docs::find($doc_id)) {
                    $doc->status = 'enviado';
                    $doc->save();
                    $docHistory = new DocsHistory(
                        [
                            'doc_id' => $doc_id,
                            'description' => "capa_enviada",
                            'user_id' => $user->id,
                        ]
                    );

                    $docHistory->save();
                    $regs++;
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            if ($in_transaction == true) {
                DB::rollback();
            }
            return response()->json($e->getMessage(), 400);
        }
        return response()->json(
            sprintf('%s Remessa%s Registrada%2$s', ($regs > 0 ? $regs : 'Nenhuma'), $regs > 1 ? 's' : ''), 200
        );
    }

    public function contingencia(Request $request)
    {
        $params = $request->all();
        print_r($params);

    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function history(Request $request, $id)
    {
        try {
            $res = [];
            if (!$doc = Docs::find($id)) {
                throw new Exception('Capa de Lote inexistente');
            }
            if (!$file = $doc->file) {
                throw new Exception('Arquivo não encontrado');
            }
            if ($file->constante == "DM") {
                $doc->dest = $doc->from_agency;
                $doc->origin = "DM";
            } else {
                $doc->origin = $doc->from_agency;
                $doc->dest = $doc->to_agency;
            }
            $doc->register = "Upload do Arquivo";
            $doc->status = __('status.' . $doc->status);
            if (!$user = $doc->user) {
                throw new Exception('Erro ao buscar informações de usuário de capa de lote');
            }
            $doc->unidade = strlen($user->juncao) > 0 ? $user->juncao : $user->unidade;

            foreach ($doc->history as $h) {
                $h->content = $doc->content;
                if ($file->constante == "DM") {
                    $h->dest = $doc->from_agency;
                    $h->origin = "DM";
                } else {
                    $h->origin = $doc->from_agency;
                    $h->dest = $doc->to_agency;
                }
                if (!$user = $h->user) {
                    throw new Exception('Erro ao buscar informações de usuário de histórico');
                }
                $user->juncao = ($user->juncao == null ? '-' : $user->juncao);

                $h->register = __('status.' . $h->description);
                $h->unidade = (int)$h->juncao > 0 ? $h->juncao : ($h->unidade != null ? $h->unidade : '-');
                $res[] = $h;
            }

            echo json_encode($res);

        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 400);
        }

    }

}