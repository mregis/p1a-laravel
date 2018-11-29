<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Users;
use App\Models\Audit;
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
use Illuminate\Support\Facades\Hash;

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
        $files = Files::all();
        foreach($files as &$file){
                $pendentes = 0;
                $dcs = Docs::where('file_id', $file->id)->get();
                $docs = array();
                foreach($dcs as &$d){
                    if(Auth::user()->profile == 'ADMINISTRADOR') {
                        $docs[] = $d;
                    } else {
                        if(substr($d->content,0,4) == Auth::user()->juncao) {
                            $docs[] = $d;
                        }
                    }
            if($d->status == 'pendente') {
                        $pendentes++;
            }
                }
                $file->pendentes = $pendentes;
        }
        return view('receive.receive', compact('menus', 'files'));
    }

    public function list(Request $request, $id)
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

    public function removearquivo(Request $request,$id)
    {
        $menu = new Menu();
        $menus = $menu->menu();
//        return view('upload.upload_list', compact('menus'));
    }

    public function docs(Request $request, $id , $profile , $juncao = false)
    {
	 $params = array('file_id'=> $id);
        $file = Files::where('id', $id)->first();
        $query = Docs::query()
            ->where($params)->orderBy('created_at', 'desc');
        if ($profile != 'ADMINISTRADOR') {
            if ($file->constante == "DM") {
                $query = Docs::query()
                    ->where([
                        ['file_id', '=', $id],
                        ['content', 'like', sprintf("%04d", $juncao) . '%'],
                    ])
                    ->orWhere(function ($query) {
                        $query->whereNotIn('status', ['pendente','recebido'])
                            ->whereNull('status');
                    })
                    ->orderBy('created_at', 'desc')
                ;
            } else {
                $query = Docs::query()
                    ->where([
                        ['file_id', '=', $id],
                        ['content', 'like', '%' . sprintf("%04d", $juncao)],
                    ])
                    ->orWhere(function ($query) {
                        $query->whereNotIn('status', ['pendente','recebido'])
                            ->whereNull('status');
                    })
                    ->orderBy('created_at', 'desc')
                ;
            }
        }

        return Datatables::of($query)
            ->addColumn('action', function ($doc) {
                return '<input style="float:left;width:20px;margin: 6px 0 0 0;" ' .
                    'type="checkbox" name="lote[]" class="form-control m-input input-doc" ' .
                    'value="'. $doc->id.'">';
            })
            ->addColumn('origem', function ($doc) use ($file) {
                $doc->content = trim($doc->content);
                return ($file->constante == "DM" ? "DM" : substr($doc->content, 0, 4));
            })
            ->addColumn('destino', function ($doc) use ($file) {
                $doc->content = trim($doc->content);
                return ($file->constante == "DM" ? substr($doc->content, 0, 4) : substr($doc->content, -4, 4));
            })
            ->addColumn('status', function($doc) {
                return $doc->status ? $doc->status : '-';
            })
            ->editColumn('created_at', function ($doc) {
                return $doc->created_at ? with(new Carbon($doc->created_at))->format('d/m/Y H:i:s') : '';
            })
            ->editColumn('updated_at', function ($doc) {
                return $doc->created_at ? with(new Carbon($doc->created_at))->format('d/m/Y H:i:s') : '';
            })
            ->make(true);
    }

    public function destroy(Request $request, $id)
    {
        die('aki');
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
        $params = $request->all();

        foreach($params['doc'] as &$doc){
                if($docs = Docs::where('id',$doc)->first()){
                        $docs->status = 'recebido';
                        $docs->user_id = $params['user'];
                        $docs->save();
                        $docsHistory = new DocsHistory();
                        $docsHistory->doc_id = $doc;
                        $docsHistory->description = "Capa recebida";
                        $docsHistory->user_id = $params['user'];
                        $docsHistory->save();                        

                }
        }
    }
    public function registeroperador(Request $request)
    {
        $params = $request->all();

        if($seal = Seal::where('content',$params['lacre'])->first()){
                $id = $seal->id;
        }else{
		$seal = new Seal();
		$seal->user_id = $params['user'];
		$seal->content = $params['lacre'];
		$seal->save();
		$id = $seal->id;
        }
        foreach($params['doc'] as &$d){
            $doc = Docs::where('content','like','%'.trim($d).'%')->first();
	    if($doc->id){
                $doc->status = 'em trânsito';
                $doc->user_id = $params['user'];
                $doc->save();

                $docsHistory = new DocsHistory();
                $docsHistory->doc_id = $doc->id;
                $docsHistory->description = "Capa em trânsito";
                $docsHistory->user_id = $params['user'];
                $docsHistory->save();                        
                if($sealGroup = SealGroup::where('doc_id',$doc->id)->first()){
                    $idGroup = $sealGroup->id;
                } else {
                    $sealGroup = new SealGroup();
                    $sealGroup->seal_id = $id;
                    $sealGroup->doc_id = $doc->id;
                    $sealGroup->save();
                    $idGroup = $sealGroup->id;
                }
            }
        }
        return $this->sendResponse($idGroup, 'Informação atualizada com sucesso');
    }
    public function operador(Request $request)
    {
        $menu = new Menu();
        $menus = $menu->menu();

	$files = Files::all();
	foreach($files as &$file){
		$docs = Docs::where('file_id', $file->id)->get();
		$pendentes = 0;
		foreach($docs as &$d){
			if($d->status == 'pendente'){
				$pendentes++;
			}
		}
		$file->pendentes = $pendentes;
	}
        return view('receive.operador', compact('menus','files'));
    }

    public function docListingIndex() {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('receive.receive_doclist', compact('menus', 'id'));
    }

    public function doclisting(Request $request, $profile , $juncao = false)
    {
        $query = Docs::query()
            ->select("docs.*", "files.constante as constante")
            ->join("files", "docs.file_id", "=", "files.id")
        ;
        if ($profile != 'ADMINISTRADOR') {
                $query
                    ->orWhere(function ($query) use ($juncao) {
                        $query->where([
                            ['files.constante', '=', 'DM'],
                            ['content', 'like', sprintf("%04d", $juncao) . '%']
                        ])
                            ->where(function ($query) {
                                $query->whereNotIn('status', ['recebido'])
                                    ->orWhere('status', '=', null);
                            });
                    })
                    ->orWhere(function ($query) use ($juncao) {
                        $query->where([
                            ['files.constante', '<>', 'DM'],
                            ['content', 'like', '%' . sprintf("%04d", $juncao)]
                        ])
                            ->where(function ($query) {
                                $query->whereNotIn('status', ['recebido'])
                                    ->orWhere('status', '=', null);
                            });
                    });

        }
        return Datatables::of($query)
            ->addColumn('action', function ($doc) {
                return '<input style="float:left;width:20px;margin: 6px 0 0 0;" ' .
                'type="checkbox" name="lote[]" class="form-control m-input input-doc" ' .
                'value="'. $doc->id.'">';
            })
            ->editColumn('content', function($doc) {
                return '<a data-toggle="modal" href="#modal" onclick="getHistory(' . $doc->id . ')" ' .
                'title="Histórico" class="btn btn-primary m-btn m-btn--icon">' . $doc->content .
                '</a>';
            })
            ->editColumn('constante', function ($doc) {
                $doc->content = trim($doc->content);
                return ($doc->constante == "DM" ? "Devolução Matriz" : "Devolução Agência");
            })
            ->addColumn('origem', function ($doc) {
                $doc->content = trim($doc->content);
                return ($doc->constante == "DM" ? "<b>4510</b>" : substr($doc->content, 0, 4));
            })
            ->addColumn('destino', function ($doc) {
                $doc->content = trim($doc->content);
                return ($doc->constante == "DM" ? substr($doc->content, 0, 4) : substr($doc->content, -4, 4));
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

}
