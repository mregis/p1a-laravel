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

class UploadController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
				if($files->save()){
					foreach($rows as &$r){
						$docs = new Docs();
						$docs->file_id = $files->id;
						$docs->content = $r;
						$docs->save();
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

        $files->delete();

        return $this->sendResponse(null, 'Informação excluída com sucesso');
    }
    public function docs(Request $request, $id)
    {
	$dcs = Docs::where('file_id', $id)->get();
        $docs = array();
        foreach($dcs as &$d){
            if(Auth::user()->profile == 'ADMINISTRADOR'){
                $docs[] = $d;
            } else {
                if(substr($d->content,0,4) == Auth::user()->juncao){
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

}
