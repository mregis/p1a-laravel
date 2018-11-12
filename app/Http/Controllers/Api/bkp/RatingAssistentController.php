<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\RatingAssistent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class RatingAssistentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $rating = RatingAssistent::where('id', '>', 0)->get();
        return $this->sendResponse($rating->toArray(), 'Informação recuperada com sucesso');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rating = RatingAssistent::where('id', '>', '0')->get();
        return $this->sendResponse($rating->toArray(), 'Informação recuperada com sucesso');
    }

    /**
     * @SWG\Post(
     *     path="/assistent",
     *     operationId="store",
     *     summary="Adiciona um novo assistente",
     *     tags={"RatingAssistent"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Definition(
     *              @SWG\Property(property="name", type="integer"),
     *              @SWG\Property(property="phone", type="string"),
     *              @SWG\Property(property="email", type="string"),
     *              @SWG\Property(property="value", type="string"),
     *         )
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Informação adicionada com sucesso",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Erro na validação dos dados",
     *     )
     * )
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $assistent = RatingAssistent::where('assistent_id', $input['assistent_id'])->first();
        if (!is_null($assistent)) {
            return $this->sendError('Assistente já foi avaliado', 200);
        }

        $notes = $input['note'];
        $questions = $input['question_id'];
        foreach ($notes as $key => $note) {
            $input['note'] = $note;
            $input['question_id'] = $questions[$key];
            RatingAssistent::create($input);
            $input['obs'] = "";
        }

        return $this->sendResponse(null, 'Avaliação cadastrada com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rating = RatingAssistent::where('id', $id)->first();
        return $this->sendResponse($rating, 'Informação recuperada com sucesso');
        //
    }

    public function showAssistents($id)
    {
        $rating = RatingAssistent::where('assistent_id', $id)->get();
        return $this->sendResponse($rating->toArray(), 'Informação recuperada com sucesso');
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
        $rating = RatingAssistent::where('assistent_id', $id)->get();
        if (is_null($rating)) {
            return $this->sendError('Informação não encontrada', 404);
        }
        $input = $request->all();
        $notes = $input['note'];
        $questions = $input['question_id'];
        $input2['assistent_id'] = $rating[0]['assistent_id'];
        foreach ($rating as $key => $rat) { // pegar todos id das questões já respondidas de determinado assitente
            $array_questions[$key] = $rat['question_id']; // array de questões já respondidas
        }
        foreach ($questions as $key => $question) { // pegar todos id das questões que estão vindo do front
            $array_questionsRes[$key] = $question; // array de questões respondias do front
            if (!in_array($question, $array_questions)) {
                $input2['question_id'] = $question;
                $input2['note'] = $notes[$key];
                RatingAssistent::create($input2);
                $rating = RatingAssistent::where('assistent_id', $id)->get();
            }
        }
        foreach ($notes as $key => $note) {
            if ($note == null) {
                $note = 0;
            }
            $input['note'] = $note;
            $input['question_id'] = $questions[$key];
            $rating[$key]->fill($input)->save();
        }
        return $this->sendResponse($rating->toArray(), 'Informação atualizada com sucesso');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rating = RatingAssistent::where('id', $id)->first();

        if (is_null($rating)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $rating->delete();

        return $this->sendResponse(null, 'Informação excluída com sucesso');

    }

    public function ranking()
    {
        $ranking = DB::select('select * from avg_rating_assistant');
        $ranking = collect($ranking);

//        return $this->sendResponse($ranking, 'Informação recuperada com sucesso');
        return Datatables::of($ranking)->make(true);

    }

}
