<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 07/01/2019
 * Time: 21:53
 */

namespace app\Http\Controllers\Anon;


use App\Http\Controllers\Controller;
use App\Models\Docs;
use Illuminate\Http\Request;

class AnonController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function getCapaLoteHistory(Request $request)
    {
        $capalote = $request->get('capalote');
        if (!$doc = Docs::where('content', $capalote)->first()) {
            $request->session()->flash('alert-danger', 'Erro ao recuperar informações. ' .
                'Tente novamente. Se o problema persistir informe ao Administrador do Sistema');
            return redirect(route('anon.check_capalote'));
        }
        $request->session()->put('doc', $doc);
        return redirect(route('anon.show_capalote_history'));
    }

    public function showCapaLoteHistory(Request $request)
    {
        if ($request->session()->has('doc')) {
            $doc = $request->session()->pull('doc');
            return view('anon.show_capalote', compact('doc'));
        }
        $request->session()->flash('alert-danger', 'A exibição expirou ou houve um erro ao recuperar informações.');
        return redirect(route('anon.check_capalote'));
    }

    public function checkCapaLote()
    {
        return view('anon.check_capalote');
    }
}