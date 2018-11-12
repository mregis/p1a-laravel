<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Question;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class QuestionController extends BaseController
{

    public function list()
    {
        $questions = Question::where('id','>', 0)->get();
//        return $this->sendResponse($clients->toArray(), 'Informação recuperada com sucesso');

        return Datatables::of($questions)
            ->addColumn('action', function ($questions) {
                return '<div align="center"><a href="questions/edit/' . $questions->id . '" data-toggle="tooltip" title="Editar" class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-pencil-square"></i></a><button onclick="modalDelete(' . $questions->id . ')" data-toggle="tooltip" title="Excluir" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-trash"></i></button></div>';
            })
            ->make(true);
    }

    public function index()
    {
        $questions = Question::all();
        return $this->sendResponse($questions->toArray(), 'Informação recuperada com sucesso');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $question = Question::create($input);
        $ret = "/questions/" . $question->id;
        return $this->sendResponse(null, 'Pergunta cadastrado com sucesso', $ret);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::where('id', $id)->first();

        if (is_null($question)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        return $this->sendResponse($question->toArray(), 'Informação recuperada com sucesso');
        //
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
        $question = Question::where('id', $id)->first();

        if (is_null($question)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $input = $request->all();

        $question->fill($input)->save();

        return $this->sendResponse($question->toArray(), 'Informação atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::where('id', $id)->first();

        if (is_null($question)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $question->delete();

        return $this->sendResponse(null, 'Pergunta excluída com sucesso');
    }
}
