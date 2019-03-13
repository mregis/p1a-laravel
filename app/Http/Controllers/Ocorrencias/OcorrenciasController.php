<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 22/02/2019
 * Time: 18:44
 */

namespace app\Http\Controllers\Ocorrencias;


use App\Http\Controllers\BaseController;
use App\Models\Alerts;
use App\Models\Menu;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OcorrenciasController extends BaseController
{

    public function index() {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('ocorrencias.index', compact('menus'));
    }

    public function reportarRoubo() {
        $menu = new Menu();
        $menus = $menu->menu();
        return view('ocorrencias.report_theft', compact('menus'));
    }

    public function _add() {
        $menu = new Menu();
        $menus = $menu->menu();
        // List of Basic Ocorrencia Types
        $ocorrencia_types = [];
        $reflectionClass = new \ReflectionClass(Alerts::class);
        foreach ($reflectionClass->getReflectionConstants() as $constant) {
            if (strpos($constant->getName(), 'TYPE_') > -1) {
                $ocorrencia_types[] = $constant->getValue();
            }
        }

        // List of Products
        $products = Products::all();
        return view('ocorrencias.add', compact('menus', 'ocorrencia_types', 'products'));
    }

    /**
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $alert_data = $request->all();
        $alert_data['user_id'] = $user->id;
        $validator = Validator::make($alert_data, [
            'product' => 'required',
            'type' => 'required',
            'content' => 'required|min:3',
        ]);

        $validator->after(function ($validator) use (&$alert_data) {
            // check Product
            if (!$product = Products::find($alert_data['product'])) {
                $validator->errors()->add('product',
                    'Selecione um Produto válido!');
            }
            $alert_data['product_id'] = $alert_data['product'];
            // check Type
            $ocorrencia_types = [];
            $reflectionClass = new \ReflectionClass(Alerts::class);
            foreach ($reflectionClass->getReflectionConstants() as $constant) {
                if (strpos($constant->getName(), 'TYPE_') > -1) {
                    $ocorrencia_types[] = $constant->getValue();
                }
            }
            if (!in_array($alert_data['type'], $ocorrencia_types)) {
                $validator->errors()->add('type',
                    'Tipo inválido! Verifique as informações. Persistindo o problema contate o Administrador');
            }

        });

        if ($validator->fails()) {
            $request->session()->flash('alert-danger',
                'Erros encontrados. Verifique as informações e tente novamente!');
            return redirect(route('ocorrencias.add'))
                ->withErrors($validator)
                ->withInput($request->all());
        }


        if (!$ocorrencia = Alerts::create($alert_data)) {
            $request->session()->flash('alert-danger',
                'Não foi possível cadastrar a ocorrência neste momento. Tente novamente mais tarde!');
        } else {
            $request->session()->flash('alert-success', 'Ocorrência cadastrada com sucesso!');
        }
        return redirect(route('ocorrencias.index'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!$ocorrencia =  Alerts::find($id)) {
            throw new NotFoundHttpException("Recurso não encontrado.");
        }
        $menu = new Menu();
        $menus = $menu->menu();
        return view('ocorrencias.edit', compact('ocorrencia', 'menus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if (!$ocorrencia = Alerts::find($id)) {
            throw new NotFoundHttpException("Recurso não encontrado.");
        }
        $input = $request->all();
        $ocorrencia->description .= "\n[" . date('d-m-Y H:i') .'] ' . $input['description'];
        $ocorrencia->save();
        if (!$ocorrencia->save()) {
            $request->session()->flash('alert-danger',
                'Não foi possível atualizar a ocorrência neste momento. Tente novamente mais tarde!');
        } else {
            $request->session()->flash('alert-success', 'Ocorrência atualizada com sucesso!');
        }


        return redirect(route('ocorrencias.index'));
    }
}