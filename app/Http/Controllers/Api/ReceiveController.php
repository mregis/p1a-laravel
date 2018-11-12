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
use App\Menu;
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
		$docs = Docs::where('file_id', $file->id)->get();
		$pendentes = 0;
		foreach($docs as &$d){
			if($d->status == 'pendente'){
				$pendentes++;
			}
		}
		$file->pendentes = $pendentes;
	}
        return view('receive.receive', compact('menus','files'));
    }
    public function list(Request $request,$id)
    {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('receive.receive_list', compact('menus','id'));
    }
    public function arquivos(Request $request)
    {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('upload.upload_list', compact('menus'));
    }
    public function arquivo(Request $request,$id)
    {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('upload.upload_edit', compact('menus','id'));
    }
    public function removearquivo(Request $request,$id)
    {
        $menu = new Menu();
        $menus = $menu->menu();
//        return view('upload.upload_list', compact('menus'));
    }
    public function docs(Request $request, $id)
    {
	$params = array('file_id'=> $id,'status'=>'pendente');
	//$docs = Docs::where('file_id', $id)->get();
	$docs = Docs::where($params)->get();

        return Datatables::of($docs)
            ->addColumn('action', function ($docs) {
                return '<input style="float:left;width:20px;margin: 6px 0 0 0;" type="checkbox" name="lote[]" class="form-control m-input input-doc" value="'.$docs->id.'">';
            })
            ->addColumn('origin', function ($docs) {
                return substr($docs->content,0,4);
            })
            ->addColumn('destin', function ($docs) {
                return substr($docs->content, -6 , 6);
            })
            ->editColumn('created_at', function ($docs) {
                return $docs->created_at ? with(new Carbon($docs->created_at))->format('d/m/Y H:i:s') : '';
            })
            ->editColumn('updated_at', function ($docs) {
                return $docs->created_at ? with(new Carbon($docs->created_at))->format('d/m/Y H:i:s') : '';
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
	        if($doc = Docs::where('content',$d)->first()){
			$doc_id = $doc->id;
	        } else {
			$doc = new Docs();
			$doc->content = $d;
			$doc->status = 'recebido';
			$doc->user_id = $params['user'];
			$doc->save();
			$doc_id = $doc->id;
        	}
                if($sealGroup = SealGroup::where('doc_id',$doc_id)->first()){
                        $idGroup = $sealGroup->id;
                } else {
                        $sealGroup = new SealGroup();
                        $sealGroup->seal_id = $id;
                        $sealGroup->doc_id = $doc_id;
                        $sealGroup->save();
                        $idGroup = $sealGroup->id;
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

}
