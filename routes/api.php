<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Users
Route::group(['prefix' => '/users'], function () {
    Route::get('/', 'Api\UsersController@index');
    Route::get('/list', 'Api\UsersController@list');
    Route::post('/', 'Api\UsersController@store');
    Route::get('/{id}', 'Api\UsersController@show');
    Route::put('/{id}', 'Api\UsersController@update');
    Route::delete('/{id}', 'Api\UsersController@destroy');
});

//Ocorrências
Route::group(['prefix' => '/alerts'], function () {
    Route::get('/', 'Api\AlertsController@index');
    Route::get('/list', 'Api\AlertsController@list');
    Route::post('/', 'Api\AlertsController@store');
    Route::get('/{id}', 'Api\AlertsController@show');
    Route::post('/{id}', 'Api\AlertsController@update');
    Route::delete('/{id}', 'Api\AlertsController@destroy');
});

Route::get('/audit/list', 'Api\AuditController@list');


Route::post('/products/', 'Api\ProductsController@store');
Route::post('/upload/{user_id}', 'Api\UploadController@index');
Route::get('/upload/list', 'Api\UploadController@list');
Route::get('/upload/docs/{id}/{profile}/{juncao}', 'Api\UploadController@docs');
Route::get('/upload/docs/{id}/{profile}', 'Api\UploadController@docs');
Route::get('/upload/report/{id}/{profile}/{juncao}', 'Api\UploadController@report');
Route::get('/upload/report/{id}/{profile}', 'Api\UploadController@report');

Route::delete('upload/{id}', 'Api\UploadController@destroy');

Route::get('/receive/docs/{id}/{profile}/{juncao}', 'Api\ReceiveController@docs');
Route::get('/receive/docs/{id}/{profile}', 'Api\ReceiveController@docs');

Route::post('/remessa/registrar', 'Api\UploadController@register');
Route::post('/receber/registrar', 'Api\ReceiveController@register');
Route::post('/receber/registraroperador', 'Api\ReceiveController@registeroperador');

Route::get('/report/list', 'Api\ReportController@list');
Route::get('/report/docs/{id}', 'Api\ReportController@docs');

Route::post('/contingencia', 'Api\UploadController@contingencia');

Route::post('/perfil/', 'Api\ProfileController@store');
