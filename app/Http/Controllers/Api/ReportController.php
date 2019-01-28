<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Users;
use App\Models\Audit;
use App\Models\Files;
use App\Models\Docs;
use App\Models\Seal;
use App\Models\SealGroup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Auth;

class ReportController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->hasFile('file')) {
            if ($file = $request->file('file')->isValid()) {
                $name = $request->file->getClientOriginalName();
                if (($handle = fopen($request->file->getPathName(), 'r')) !== FALSE) {
                    set_time_limit(0);
                    $row = 0;
                    while (!feof($handle)) {
                        $rows[$row] = fgets($handle);
                        $row++;
                    }
                    fclose($handle);
                }
                $files = new Files();
                $files->name = $name;
                $files->total = count($rows);
                $files->constante = substr($name, 0, 2);
                $files->codigo = substr($name, 2, 3);
                $files->movimento = new \DateTime();
                $files->sequencial = substr($name, 12, 1);
                if ($files->save()) {
                    foreach ($rows as &$r) {
                        $docs = new Docs();
                        $docs->file_id = $files->id;
                        $docs->content = $r;
                        $docs->from_agency = ($files->constante == 'DM' ? '4510' : substr($r, 0, 4));
                        $docs->to_agency = ($files->constante == 'DM' ? substr($r, 0, 4) : substr($r, -4, 4));
                        $docs->status = ($files->constante == 'DM' ? 'enviado' : 'pendente');
                        $docs->save();
                    }
                }
            }
            exit();
        }


        $menu = new Menu();
        $menus = $menu->menu();
        return view('upload.upload', compact('menus'));
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function list($user_id)
    {
        if (!$user = Users::find($user_id)) {
            return $this->response()->json("Erro ao verificar permissões", 400);
        }
        $query = Files::query()
            ->select(
                [
                    "files.id as id", "files.constante as constante", "files.name as name",
                    "files.movimento as movimento", "files.created_at as created_at",
                    "files.updated_at as updated_at",
                    DB::raw("count(files.id) as total"),
                ])
            ->join("docs", "files.id", "=", "docs.file_id")
            ->groupBy(["files.id", "files.constante", "files.name", "files.movimento",
                "files.created_at", "files.updated_at"]);
        if ($user->juncao != null) {
            $query->orWhere("docs.from_agency", "=", $user->juncao)
                ->orWhere("docs.to_agency", "=", $user->juncao);
        }

        return Datatables::of($query)
            ->addColumn('action', function ($file) {
                return '<div align="center"><a href="/report-remessa/' . $file->id . '" data-toggle="tooltip" title="Ver" class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only"><i class="fas fa-eye"></i></a></div>';
            })
            ->editColumn('created_at', function ($file) {
                return $file->created_at ? with(new Carbon($file->created_at))->format('d/m/Y H:i') : '';
            })
            ->editColumn('updated_at', function ($file) {
                return $file->created_at ? with(new Carbon($file->created_at))->format('d/m/Y H:i') : '';
            })
            ->editColumn('movimento', function ($file) {
                return with(new Carbon($file->movimento))->format('d/m/Y');
            })
            ->editColumn('constante', function ($file) {
                return trans('labels.' . $file->constante);
            })
            ->make(true);
        }

    public function remessa(Request $request)
    {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('report.upload_list', compact('menus'));
    }

    public function arquivo(Request $request, $id)
    {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('upload.report', compact('menus', 'id'));
    }

    public function removearquivo(Request $request, $id)
    {
        $files = Files::where('id', $id)->first();

        if (is_null($files)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $files->delete();

        return $this->sendResponse(null, 'Informação excluída com sucesso');
    }

    public function docs(Request $request, $id)
    {
        $docs = Docs::where('file_id', $id)->get();

        return Datatables::of($docs)
            ->addColumn('action', function ($docs) {
                return '<div align="center"><a href="#">Histórico</a></div>';
            })
            ->editColumn('created_at', function ($docs) {
                return $docs->created_at ? with(new Carbon($docs->created_at))->format('d/m/Y H:i') : '';
            })
            ->editColumn('updated_at', function ($docs) {
                return $docs->created_at ? with(new Carbon($docs->created_at))->format('d/m/Y H:i') : '';
            })
            ->editColumn('status', function ($doc) {
                return $doc->status ? __('status.' . $doc->status) : '-';
            })
            ->make(true);
    }

    public function destroy(Request $request, $id)
    {
        $files = Files::where('id', $id)->first();

        if (is_null($files)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $files->delete();

        return $this->sendResponse(null, 'Informação excluída com sucesso');
    }

    public function registrar(Request $request)
    {
        $menu = new Menu();
        $menus = $menu->menu();
        $docs = Docs::where('status', 'pendente')->get();

        return view('upload.upload_register', compact('menus', 'docs'));
    }

    public function register(Request $request)
    {
        $params = $request->all();

        if ($seal = Seal::where('content', $params['lacre'])->first()) {
            $id = $seal->id;
        } else {
            $seal = new Seal();
            $seal->user_id = $params['user'];
            $seal->content = $params['lacre'];
            $seal->save();
            $id = $seal->id;
        }
        foreach ($params['doc'] as &$doc) {
            if ($sealGroup = SealGroup::where('doc_id', $doc)->first()) {
                $idGroup = $sealGroup->id;
            } else {
                $sealGroup = new SealGroup();
                $sealGroup->seal_id = $id;
                $sealGroup->doc_id = $doc;
                $sealGroup->save();
                $idGroup = $sealGroup->id;
            }
            if ($docs = Docs::where('id', $doc)->first()) {
                $docs->status = 'enviado';
                $docs->save();
            }
        }
    }

    /**
     * @param $file_id
     * @param $user_id
     * @return mixed
     */
    public function fileContent($file_id, $user_id) {
        if (!$user = Users::find($user_id)) {
            return $this->response()->json("Erro ao verificar permissões", 400);
        }
        $query = Docs::query()
            ->select([
                "docs.id",
                "docs.created_at",
                "docs.updated_at",
                "docs.status",
                "docs.content",
            ])
            ->join("files", "docs.file_id", "=", "files.id")
            ->where("files.id", $file_id)
            ;
        if ($user->juncao != null) {
            $query->orWhere("docs.from_agency", "=", $user->juncao)
                ->orWhere("docs.to_agency", "=", $user->juncao);
        }
        return Datatables::of($query)
            ->addColumn('action', function ($doc) use ($user) {
                return sprintf('<a data-toggle="modal" href="#capaLoteHistoryModal" onclick="getHistory(%d,\'%s\',%d)" ' .
                    'title="Histórico" class="btn btn-sm btn-outline-primary m-btn m-btn--icon m-btn--icon-only">' .
                    '<i class="fas fa-eye"></i></a>', $doc->id, route('docshistory.get-doc-history'), $user->id);
            })
            ->editColumn('created_at', function ($doc) {
                return $doc->created_at ? with(new Carbon($doc->created_at))->format('d/m/Y H:i') : '';
            })
            ->editColumn('updated_at', function ($doc) {
                return $doc->updated_at ? with(new Carbon($doc->updated_at))->format('d/m/Y H:i') : '';
            })
            ->editColumn('status', function ($doc) {
                return $doc->status ? __('status.' . $doc->status) : '-';
            })
            ->make(true);
    }
}
