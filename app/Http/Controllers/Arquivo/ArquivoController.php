<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 22/01/2019
 * Time: 17:13
 */

namespace app\Http\Controllers\Arquivo;


use App\Http\Controllers\BaseController;
use App\Models\Files;
use App\Models\Menu;
use Illuminate\Http\Request;

class ArquivoController extends BaseController
{

    /**
     * @param Request $request
     * @param $file_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function file(Request $request, $file_id)
    {
        if (!$file = Files::find($file_id)) {
            $request->session()->flash('alert-danger', 'Informação não encontrada');
            return redirect(route('home'));
        }
        $menu = new Menu();
        $menus = $menu->menu();
        return view('arquivo.file', compact('menus', 'file'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listagemRemessa(Request $request)
    {
        $menus = $this->menu->menu();
        return view('arquivo.listagem_remessa', compact('menus'));
    }
}