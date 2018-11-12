<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\States;

class StatesController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // http://massad.luby.com.br/api/estado
    public function index()
    {
	$states = States::where('id','>', 0)->orderBy('name')->get();
	return $this->sendResponse($states->toArray(), 'Informação recuperada com sucesso');
    }
    // http://massad.luby.com.br/api/estado/17
    public function show($id)
    {
        $states = States::where('id', $id)->first();
	return $this->sendResponse($states->toArray(), 'Informação recuperada com sucesso');
    }
    // http://massad.luby.com.br/api/estado/nome/GO
    public function showByName($name)
    {
	$states = States::where('abbr',$name)->get();
	return $this->sendResponse($states->toArray(), 'Informação recuperada com sucesso');
    }
}
