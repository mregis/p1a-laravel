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
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CapaLoteController extends BaseController
{

    /**
     * @param Request $request
     * @param $user_id
     * @return mixed
     */
    public function index(Request $request, $user_id) {
        if (!$user = Users::find($user_id)) {
            $this->sendError('Ocorreu um erro ao validar o acesso ao conteúdo.', 400);
        }
        $query = Docs::query()
            ->select("docs.*")
            ->join("files", "docs.file_id", "=", "files.id")
            ->where("files.constante", "=", "RA")
        ;
        if ($user->juncao != null) {
            $query->where([
                ['docs.content', 'like', sprintf("%04d", $user->juncao) . '%']
            ]);
        }
        return Datatables::of($query)
            ->addColumn('action', function ($docs) {
                return '<div align="center"><button class="btn m-btn m-btn--icon m-btn--icon-only print-capalote" ' .
                'onclick="view(' . $docs->id . ')" title="Imprimir">' .
                '<i class="fas fa-print"></i></button></div>';
            })
            ->addColumn('origem', function ($doc) {
                $doc->content = trim($doc->content);
                return substr($doc->content, 0, 4);
            })
            ->addColumn('destino', function ($doc) {
                $doc->content = trim($doc->content);
                return (substr($doc->content, -4, 4));
            })
            ->addColumn('status', function($doc) {
                return $doc->status ? $doc->status : '-';
            })
            ->editColumn('updated_at', function ($doc) {
                return $doc->updated_at ? with(new Carbon($doc->updated_at))->format('d/m/Y H:i') : '';
            })
            ->editColumn('created_at', function ($doc) {
                return $doc->created_at? with(new Carbon($doc->created_at))->format('d/m/Y') : '';
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function _new(Request $request) {
        // Check the user
        $validatedData = $request->validate([
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
        ]);

    }

    public function downloadCapaLotePDF(Request $request, $doc_id) {


    }
}