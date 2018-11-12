<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Assistent;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Yajra\Datatables\Datatables;


class AssistentController extends BaseController
{

    public function list()
    {
        $assistent = Assistent::where('id', '>', 0)->get();
//        return $this->sendResponse($assistent->toArray(), 'Informação recuperada com sucesso');
        return Datatables::of($assistent)
            ->addColumn('action', function ($assistent) {
                if ($assistent->active) {
                    $status = '<button onclick="disable(' . $assistent->id . ')" data-toggle="tooltip" title="Desativar" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-lock"></i></button>';
                } else {
                    $status = '<button onclick="active(' . $assistent->id . ')" data-toggle="tooltip" title="Ativar" class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-unlock"></i></button>';
                }
                return '<div align="center">' . $status . '<a href="edit/' . $assistent->id . '" data-toggle="tooltip" title="Editar" class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-pencil-square"></i></a><button onclick="modalDelete(' . $assistent->id . ')" data-toggle="tooltip" title="Excluir" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-trash"></i></button></div>';
            })
            ->make(true);

    }

    public function index()
    {
        $assistent = Assistent::where('id', '>', 0)
            ->where('active', 1)
            ->orderBy('name')
            ->get();
        return $this->sendResponse($assistent->toArray(), 'Informação recuperada com sucesso');

    }


    public function create()
    {
        $assistent = Assistent::where('id', '>', '0')->get();
        return $this->sendResponse($assistent->toArray(), 'Informação recuperada com sucesso');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        if ($request->hasFile('signature')) {
            $image = $request->signature;
            $image_name = $this->removeCharacters($image->getClientOriginalName());
            $image_name = time() . '.' . $image_name;

            $image->move("images/SignatureAssistents/", $image_name);

            Image::make("images/SignatureAssistents/" . $image_name)->resize(512, 512)->save("images/SignatureAssistents/" . $image_name);
            $input['signature'] = "images/SignatureAssistents/" . $image_name;
        }
        $assistent = Assistent::create($input);
        $ret = "/assistent/" . $assistent->id;
        return $this->sendResponse(null, 'Assistente cadastrado com sucesso', $ret);
    }


    public function show($id)
    {
        $assistent = Assistent::where('id', $id)->first();
        return $this->sendResponse($assistent->toArray(), 'Informação recuperada com sucesso');
        //
    }


    public function update(Request $request, $id)
    {
        $assistent = Assistent::where('id', $id)->first();

        if (is_null($assistent)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $input = $request->all();

        $assistent->fill($input)->save();

        return $this->sendResponse($assistent->toArray(), 'Informação atualizada com sucesso');

    }

    public function destroy($id)
    {
        $assistent = Assistent::where('id', $id)->first();
        if (is_null($assistent)) {
            return $this->sendError('Informação não encontrada', 404);
        }
        $assistent->delete();
        return $this->sendResponse(null, 'Informação excluída com sucesso');
    }
    public function active($id)
    {
        $assistent = Assistent::where('id', $id)
            ->first();
        if (is_null($assistent)) {
            return response()->json([
                'result' => false,
                'message' => 'Informação não encontrada',
            ], 404);
        }
        $input['active'] = 1;
        $assistent->fill($input)->save();
        return response()->json([
            'result' => true,
            'message' => 'Assistente ativado com sucesso',
        ], 200);
    }

    public function disable($id)
    {
        $assistent = Assistent::where('id', $id)
            ->first();
        if (is_null($assistent)) {
            return response()->json([
                'result' => false,
                'message' => 'Informação não encontrada',
            ], 404);
        }
        $input['active'] = 0;
        $assistent->fill($input)->save();
        return response()->json([
            'result' => true,
            'message' => 'Assistente desativado com sucesso',
        ], 200);

    }

    public function removeCharacters($string)
    {
        return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $string);
    }
}