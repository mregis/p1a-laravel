<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Menu;
use App\Sub_Menu;
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
                              if($f->constante == "DA"){
                                $da[$f->dia.'/'.$f->mes.'/'.$f->ano] = $f->total;
                              }
                              if($f->constante == "DM"){
                                $dm[$f->dia.'/'.$f->mes.'/'.$f->ano] = $f->total;
                              }
  //                          $docs = Docs::where('file_id',$f->)->get();                               
                        }
                        $dr = Docs::where('user_id','<>',null)->get();

                        return view('dashboard/dashboard', compact('menus','profile','da','dm','dr'));
		}
	}
}
