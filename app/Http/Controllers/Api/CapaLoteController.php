<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 10/12/2018
 * Time: 23:37
 */

namespace app\Http\Controllers\Api;


use App\Http\Controllers\BaseController;
use App\Models\Docs;
use App\Models\Files;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Yajra\DataTables\DataTables;

class CapaLoteController extends BaseController
{


    /**
     * @param $user_id
     * @return mixed
     */
    public function _list(Request $request, $user_id)
    {
        try {
            if (!$user = Users::find($user_id)) {
                throw new \Exception('Erro ao verificar permissões.');
            }

            $query = Files::query()
                ->select([
                    "files.constante as constante", "files.movimento as movimento",
                    "docs.content", "docs.status", "docs.from_agency",
                    "docs.to_agency", "docs.updated_at", "docs.created_at",
                    "docs.id", "origin.nome as origin", "destin.nome as destin"
                ])
                ->join("docs", "files.id", "=", "docs.file_id")
                ->leftJoin("agencia as origin", "docs.from_agency", "=", "origin.codigo")
                ->leftJoin("agencia as destin", "docs.to_agency", "=", "destin.codigo");

            if ($user->profile != 'ADMINISTRADOR') {
                $query->where(function ($query) use ($user) {
                    $query->orWhere('docs.from_agency', '=', sprintf("%04d", $user->juncao))
                        ->orWhere('docs.to_agency', '=', sprintf("%04d", $user->juncao));
                });
            }

            return Datatables::of($query)
                ->filter(function ($query) {
                    if (request()->has('di')) {
                        if (request('di') != null) {
                            $di = new \DateTime(request('di'));
                            $query->where('files.movimento', '>=', $di);
                        }
                    }

                    if (request()->has('df')) {
                        if (request('df') != null) {
                            $df = new \DateTime(request('df'));
                            $query->where('files.movimento', '<=', $df);
                        }
                    }
                }, true)
                ->filterColumn('constante', function ($query, $keyword) {
                    $query->where('files.constante', '=', $keyword);
                })
                ->filterColumn('content', function ($query, $keyword) {
                    $query->where('docs.content', '=', $keyword);
                })
                ->filterColumn('from_agency', function ($query, $keyword) {
                    $query->where('docs.from_agency', '=', $keyword);
                })
                ->filterColumn('to_agency', function ($query, $keyword) {
                    $query->where('docs.to_agency', '=', $keyword);
                })
                ->filterColumn('status', function ($query, $keyword) {
                    $query->where('docs.status', '=', $keyword);
                })
                ->addColumn('view', function ($doc) use ($user) {
                    return '<a data-toggle="modal" href="#capaLoteHistoryModal" onclick="getHistory(' . $doc->id .
                    ',\'' . route('docshistory.get-doc-history') . '\',' . ($user->id) . ')" ' .
                    'title="Histórico" class="btn btn-sm btn-outline-primary m-btn m-btn--icon m-btn--icon-only">' .
                    '<i class="fas fa-eye"></i></a>';
                })
                ->editColumn('from_agency', function ($doc) {
                    if ($doc->origin != null) {
                        return '<a href="javascript:void();" title="' . $doc->origin . '" data-toggle="tooltip">' .
                        $doc->from_agency . '</a>';
                    } else {
                        return $doc->from_agency;
                    }
                })
                ->editColumn('to_agency', function ($doc) {
                    if ($doc->destin != null) {
                        return '<a href="javascript:void();" title="' . $doc->destin . '" data-toggle="tooltip">' .
                        $doc->to_agency . '</a>';
                    } else {
                        return $doc->to_agency;
                    }
                })
                ->editColumn('constante', function ($doc) {
                    return __('labels.' . $doc->constante);
                })
                ->editColumn('movimento', function ($doc) {
                    return with(new Carbon($doc->movimento))->format('d/m/Y');
                })
                ->editColumn('updated_at', function ($doc) {
                    return $doc->updated_at ? with(new Carbon($doc->updated_at))->format('d/m/Y H:i') : '';
                })
                ->editColumn('created_at', function ($doc) {
                    return $doc->created_at ? with(new Carbon($doc->created_at))->format('d/m/Y') : '';
                })
                ->editColumn('status', function ($doc) {
                    return __('status.' . $doc->status);
                })
                ->escapeColumns([])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function list_contigencia($user_id)
    {
        if (!$user = Users::find($user_id)) {
            $this->sendError('Ocorreu um erro ao validar o acesso ao conteúdo.', 400);
        }
        $query = Docs::query()
            ->select([
                "docs.id",
                "docs.content",
                "docs.from_agency",
                "docs.to_agency",
                "docs.created_at",
                "docs.status",
            ])
            ->join("files", "docs.file_id", "=", "files.id")
            ->where("files.constante", "=", "RA");
        if ($user->juncao != null) {
            $query->where([
                ['docs.content', 'like', sprintf("%04d", $user->juncao) . '%']
            ]);
        }
        return Datatables::of($query)
            ->addColumn('action', function ($doc) {
                return '<input type="checkbox" name="capalote[]" class="form-control form-control-sm m-input input-doc" ' .
                'value="' . $doc->id . '" id="capalote-' . $doc->id . '">';
            })
            ->addColumn('print', function ($docs) {
                return '<div align="center"><button class="btn btn-sm m-btn m-btn--icon m-btn--icon-only print-capalote" ' .
                'onclick="view(' . $docs->id . ')" title="Imprimir" type="reset">' .
                '<i class="fas fa-print"></i></button></div>';
            })
            ->editColumn('from_agency', function ($doc) {
                if ($doc->origin != null) {
                    return '<a href="javascript:void();" title="' . $doc->origin . '" data-toggle="tooltip">' .
                    $doc->from_agency . '</a>';
                } else {
                    return $doc->from_agency;
                }
            })
            ->editColumn('to_agency', function ($doc) {
                if ($doc->destin != null) {
                    return '<a href="javascript:void();" title="' . $doc->destin . '" data-toggle="tooltip">' .
                    $doc->to_agency . '</a>';
                } else {
                    return $doc->to_agency;
                }
            })
            ->editColumn('created_at', function ($doc) {
                return $doc->created_at ? with(new Carbon($doc->created_at))->format('d/m/Y') : '';
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * @param $user_id
     * @param null $file_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNotReceived($user_id, $file_id = null)
    {
        try {
            if (!$user = Users::find($user_id)) {
                throw new \Exception('Erro ao verificar permissões.');
            }

            $query = Files::query()
                ->select([
                    "files.constante as constante", "files.movimento as movimento",
                    "docs.content", "docs.status", "docs.from_agency",
                    "docs.to_agency", "docs.updated_at", "docs.created_at",
                    "docs.id", "origin.nome as origin", "destin.nome as destin"
                ])
                ->join("docs", "files.id", "=", "docs.file_id")
                ->leftJoin("agencia as origin", "docs.from_agency", "=", "origin.codigo")
                ->leftJoin("agencia as destin", "docs.to_agency", "=", "destin.codigo")
                ->whereNotIn('status', ['recebido']);
            if ($file_id > 0) {
                $query->where("files.id", "=", $file_id);
            }
            if ($user->profile != 'ADMINISTRADOR') {
                $query->where('docs.to_agency', sprintf("%04d", $user->juncao));
            }

            return Datatables::of($query)
                ->filterColumn('constante', function ($query, $keyword) {
                    $query->where('files.constante', '=', $keyword);
                })
                ->filterColumn('content', function ($query, $keyword) {
                    $query->where('docs.content', '=', $keyword);
                })
                ->filterColumn('from_agency', function ($query, $keyword) {
                    $query->where('docs.from_agency', '=', $keyword);
                })
                ->filterColumn('to_agency', function ($query, $keyword) {
                    $query->where('docs.to_agency', '=', $keyword);
                })
                ->filterColumn('status', function ($query, $keyword) {
                    $query->where('docs.status', '=', $keyword);
                })
                ->addColumn('action', function ($doc) {
                    return '<input type="checkbox" name="lote[]" class="form-control form-control-sm m-input input-doc" ' .
                    'value="' . $doc->id . '">';
                })
                ->addColumn('view', function ($doc) use ($user) {
                    return '<a data-toggle="modal" href="#capaLoteHistoryModal" onclick="getHistory(' . $doc->id .
                    ',\'' . route('docshistory.get-doc-history') . '\',' . ($user->id) . ')" ' .
                    'title="Histórico" class="btn btn-sm btn-outline-primary m-btn m-btn--icon m-btn--icon-only">' .
                    '<i class="fas fa-eye"></a>';
                })
                ->editColumn('from_agency', function ($doc) {
                    if ($doc->origin != null) {
                        return '<a href="javascript:void();" title="' . $doc->origin . '" data-toggle="tooltip">' .
                        $doc->from_agency . '</a>';
                    } else {
                        return $doc->from_agency;
                    }
                })
                ->editColumn('to_agency', function ($doc) {
                    if ($doc->destin != null) {
                        return '<a href="javascript:void();" title="' . $doc->destin . '" data-toggle="tooltip">' .
                        $doc->to_agency . '</a>';
                    } else {
                        return $doc->to_agency;
                    }
                })
                ->editColumn('constante', function ($doc) {
                    return __('labels.' . $doc->constante);
                })
                ->editColumn('status', function ($doc) {
                    return __('status.' . $doc->status);
                })
                ->editColumn('movimento', function ($doc) {
                    return with(new Carbon($doc->movimento))->format('d/m/Y');
                })
                ->editColumn('updated_at', function ($doc) {
                    return $doc->updated_at ? with(new Carbon($doc->updated_at))->format('d/m/Y H:i') : '';
                })
                ->editColumn('created_at', function ($doc) {
                    return $doc->created_at ? with(new Carbon($doc->created_at))->format('d/m/Y') : '';
                })
                ->escapeColumns([])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
    }

    /**
     * @param $user_id
     * @param bool|false $file_id
     * @return mixed
     */
    public function report($user_id, $file_id = false)
    {
        if (!$user = Users::find($user_id)) {
            $this->sendError('Erro ao verificar permissões', 400);
        }

        $query = Docs::query()
            ->select([
                'docs.id',
                'docs.content',
                'docs.status',
                'docs.created_at',
                'docs.updated_at',
                'docs.file_id'
            ])
            ->leftJoin("agencia as origin", "docs.from_agency", "=", "origin.codigo")
            ->leftJoin("agencia as destin", "docs.to_agency", "=", "destin.codigo");
        if ($file_id > 0) {
            $query->where("docs.file_id", $file_id);
        }
        if ($user->profile == 'AGÊNCIA') {
            $query->where('docs.from_agency', '=', sprintf("%04d", $user->juncao))
                ->orWhere('docs.to_agency', '=', sprintf("%04d", $user->juncao));
        }

        return Datatables::of($query)
            ->addColumn('action', function ($doc) use ($user) {
                return '<a data-toggle="modal" href="#capaLoteHistoryModal" onclick="getHistory(' . $doc->id .
                ',\'' . route('docshistory.get-doc-history') . '\',' . ($user->id) . ')" ' .
                'title="Histórico" class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only"><i class="fas fa-eye">' .
                '</a>';
            })
            ->editColumn('created_at', function ($docs) {
                return $docs->created_at ? with(new Carbon($docs->created_at))->format('d/m/Y H:i:s') : '';
            })
            ->editColumn('updated_at', function ($docs) {
                return $docs->updated_at ? with(new Carbon($docs->updated_at))->format('d/m/Y H:i:s') : '';
            })
            ->editColumn('status', function ($doc) {
                return __('status.' . $doc->status);
            })
            ->make(true);
    }


}