<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Menu;
use App\Models\Sub_Menu;
use Auth;
use App\Models\Files;
use App\Models\Docs;

class DashboardController extends Controller
{
	public function index(Request $request){
		if(!Auth::user()) return redirect('/');
		if(!$request->session()->exists('user')){
			$profile = Auth::user()->profile;
			$menu = new Menu();
			$menus = $menu->menu();
                        // Traz tudo do Files
                        $files = Files::orderBy('id', 'DESC')->get();
                        $dm = array();
                        $da = array();
                        foreach($files as &$f){
                            $docs = Docs::where('file_id',$f->id)->get();
                            $pendentes = 0;
                            $concluidos = 0;
                            foreach($docs as &$d){
                                if($d->status == 'pendente'){
                                    $pendentes++;
                                }
                                if($d->status == 'concluido' || $d->status == 'enviado' || $d->status == 'recebido'){
                                    $concluidos++;
                                }
                            }
                              if($f->constante == "DA"){
                                $da[$f->dia.'/'.$f->mes.'/'.$f->ano]['total'] = $f->total;
                                $da[$f->dia.'/'.$f->mes.'/'.$f->ano]['pendentes'] = $pendentes;
                                $da[$f->dia.'/'.$f->mes.'/'.$f->ano]['concluidos'] = $concluidos;
                              }
                              if($f->constante == "DM"){
                                $dm[$f->dia.'/'.$f->mes.'/'.$f->ano]['total'] = $f->total;
                                $dm[$f->dia.'/'.$f->mes.'/'.$f->ano]['pendentes'] = $pendentes;
                                $dm[$f->dia.'/'.$f->mes.'/'.$f->ano]['concluidos'] = $concluidos;
                              }

                        }

                        return view('dashboard/dashboard', compact('menus','profile','da','dm'));
		}
	}
}
