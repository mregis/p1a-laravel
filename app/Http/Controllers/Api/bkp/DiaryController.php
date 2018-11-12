<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Diary;
use DateTime;
use Illuminate\Http\Request;

class DiaryController extends BaseController
{

    public function index()
    {
        $diary = Diary::where('id','>', 0)->get();
        return Response()->json($diary);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $input['start'] = new DateTime($input['start']);
        $input['end'] = new DateTime($input['end']);
        $diary = Diary::create($input);
        $ret = "/diary/" . $diary->id;
        return $this->sendResponse(null, 'Cadastrado com sucesso', $ret);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
        $diary = Diary::where('id', $id)->first();

        if (is_null($diary)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $input = $request->all();

        $diary->fill($input)->save();

        return $this->sendResponse($diary->toArray(), 'Informação atualizada com sucesso');
    }

    public function destroy($id)
    {
        $diary = Diary::where('id', $id)->first();

        if (is_null($diary)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $diary->delete();

        return $this->sendResponse(null, 'Excluído com sucesso');
    }
}
