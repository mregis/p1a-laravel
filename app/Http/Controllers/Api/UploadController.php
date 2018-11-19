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
use App\Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Auth;



class UploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$user_id=false)
    {
        if($request->hasFile('file')){
                if($file = $request->file('file')->isValid()){
                        $name = $request->file->getClientOriginalName();
			$ext = substr($name,-3);
//			if($ext === 'txt' || $ext === 'TXT'){
				if(($handle = fopen($request->file->getPathName(), 'r')) !== FALSE) {
					set_time_limit(0);
					$row = 0;
					while(! feof($handle)){
						$rows[$row] = fgets($handle);
						$row++;
					}
					fclose($handle);
				}
				$files = new Files();
				$files->name = $name;
				$files->total = count($rows);
				$files->constante = substr($name,0,2);
				$files->codigo = substr($name,2,3);
				$files->dia = substr($name,5,2);
				$files->mes = substr($name,7,2);
				$files->ano = substr($name,10,2);
				$files->sequencial = substr($name,12,1);
                                $files->user_id = $user_id;
				if($files->save()){
					foreach($rows as &$r){
                                                $doc = Docs::where('content','like','%'.trim($r).'%')->first();
                                                if(!$doc && strlen($r) > 5){
                                                    $docs = new Docs();
                                                    $docs->file_id = $files->id;
                                                    $docs->content = trim($r);
                                                    $docs->user_id = $user_id;
                                                    if($files->constante == 'DM'){
                                                        $docs->status = 'enviado';
                                                    }
                                                    $docs->save();
                                                    
                                                    $history = new DocsHistory();
                                                    $history->doc_id = $docs->id;
                                                    $history->description = "Upload do Arquivo";
                                                    $history->user_id = $user_id;
                                                    $history->save();
                                                }
					}
				}

                        }
  //              }
		exit();
        }



        $menu = new Menu();
        $menus = $menu->menu();
        return view('upload.upload', compact('menus'));
    }
    public function list()
    {
        $files = Files::all();
        return Datatables::of($files)
            ->addColumn('action', function ($files) {
                return '<div align="center"><a href="/arquivo/' . $files->id . '" data-toggle="tooltip" title="Ver" class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-eye"></i></a><button onclick="modalDelete(' . $files->id . ')" data-toggle="tooltip" title="Excluir" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-trash"></i></button></div>';
            })
            ->editColumn('created_at', function ($files) {
                return $files->created_at ? with(new Carbon($files->created_at))->format('d/m/Y H:i:s') : '';
            })
            ->editColumn('updated_at', function ($files) {
                return $files->created_at ? with(new Carbon($files->created_at))->format('d/m/Y H:i:s') : '';
            })
            ->make(true);
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
        $files = Files::where('id', $id)->first();

        if (is_null($files)) {
            return $this->sendError('Informação não encontrada', 404);
        }
        $docs = Docs::where('file_id',$files->id);
        foreach($docs as &$d){
            $d->delete();
        }
        $files->delete();

        return $this->sendResponse(null, 'Informação excluída com sucesso');
    }
    public function docs(Request $request, $id, $profile,$juncao = false)
    {
	$dcs = Docs::where('file_id', $id)->get();
        $docs = array();
        foreach($dcs as &$d){
            $d->content = trim($d->content);
            if($profile == 'ADMINISTRADOR'){
                $docs[] = $d;
            } else {
                if(substr($d->content,0,4) == $juncao){
                    $docs[] = $d;
                }
            }
        }
        return Datatables::of($docs)
            ->addColumn('action', function ($docs) {
		return '';
                // return '<div align="center"><button onclick="modalDelete(' . $docs->id . ')" data-toggle="tooltip" title="Excluir" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-trash"></i></button></div>';
            })
            ->editColumn('created_at', function ($docs) {
                return $docs->created_at ? with(new Carbon($docs->created_at))->format('d/m/Y H:i:s') : '';
            })
            ->editColumn('updated_at', function ($docs) {
                return $docs->created_at ? with(new Carbon($docs->created_at))->format('d/m/Y H:i:s') : '';
            })
            ->make(true);
    }
    public function report(Request $request, $id, $profile,$juncao = false)
    {
	$dcs = Docs::where('file_id', $id)->get();
        $docs = array();
        foreach($dcs as &$d){
            $d->content = trim($d->content);
            $total_string = strlen($d->content);
            $separate = substr($d->content,($total_string - 4),4);
            if($profile == 'AGÊNCIA'){
                if(substr($d->content,0,4) == $juncao || $separate == $juncao){
                    $docs[] = $d;
                }
            } else {
                $docs[] = $d;
            }
        }
        return Datatables::of($docs)
            ->addColumn('action', function ($docs) {
                return '<div align="center"><a data-toggle="modal" href="#modal" onclick="getHistory('.$docs->id.')" title="Histórico" class="btn m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-eye"></i></button></div>';
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
	$dcs = Docs::where('status', 'pendente')->get();
        $docs = array();
        foreach($dcs as &$d){
            $d->content = trim($d->content);
            if(Auth::user()->profile == 'ADMINISTRADOR'){
                   $docs[] = $d;
            }else{
                if(substr($d->content,0,4) == Auth::user()->juncao){
                    $docs[] = $d;
                }
            }
        }
        return view('upload.upload_register', compact('menus','docs'));
    }
    public function register(Request $request)
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
	foreach($params['doc'] as &$doc){
		if($sealGroup = SealGroup::where('doc_id',$doc)->first()){
			$idGroup = $sealGroup->id;
		} else {
			$sealGroup = new SealGroup();
			$sealGroup->seal_id = $id;
			$sealGroup->doc_id = $doc;
			$sealGroup->save();
			$idGroup = $sealGroup->id;
		}
		if($docs = Docs::where('id',$doc)->first()){
			$docs->status = 'enviado';
			$docs->save();
                        $docsHistory = new DocsHistory();
                        $docsHistory->doc_id = $doc;
                        $docsHistory->description = "Capa enviada";
                        $docsHistory->user_id = $params['user'];
                        $docsHistory->save();                        
		}
	}
    }
    public function contingencia(Request $request)
    {
	$params = $request->all();
	print_r($params);

//		if($docs = Docs::where('id',$doc)->first()){
//			$docs->status = 'enviado';
//			$docs->save();
//		}
    }
    public function history(Request $request, $id)
    {
	$doc = Docs::where('id', $id)->first();
        $content = trim($doc->content);
                
        $file = Files::where('id',$doc->file_id)->first();
                
        if($file->constante == "DM"){
            $doc->dest = substr($content,0,4);
            $doc->origin = "DM";
        }else{
            $doc->origin = substr($content,0,4);
            $doc->dest = substr($content,strlen($content)-4,4);
        }


        $doc->register = "Upload do Arquivo";

        $user = Users::where('id',$doc->user_id)->first();
        $doc->user = $user;
        $doc->unidade = strlen($user->juncao) > 0 ? $user->juncao : $user->unidade;



        $history = DocsHistory::where('doc_id', $id)->get();
        foreach($history as &$h){
            $h->content = $doc->content;
            if($file->constante == "DM"){
                $h->dest = substr($content,0,4);
                $h->origin = "DM";
            }else{
                $h->origin = substr($content,0,4);
                $h->dest = substr($content,strlen($content)-4,4);
            }
            $user = Users::where('id',$h->user_id)->first();
            $h->user = $user;
            $h->register = $h->description;
            $h->unidade = strlen($h->juncao) > 0 ? $h->juncao : $h->unidade;
            $docs[] = $h;
        }
        
        echo json_encode($docs);
    }

}
