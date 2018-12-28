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
Route::post('/receber/registraroperador', 'Api\ReceiveController@registeroperador')->name('receive.register-capa-lote');

Route::get('/report/list/{user_id}', 'Api\ReportController@list')->name('report.list');
Route::get('/report/docs/{id}', 'Api\ReportController@docs');

Route::post('/contingencia', 'Api\UploadController@contingencia');

Route::post('/perfil/', 'Api\ProfileController@store');

Route::get('/receber-todos/{profile}/{juncao}', 'Api\ReceiveController@doclisting');
Route::get('/receber-todos/{profile}', 'Api\ReceiveController@doclisting');
Route::get('/remessa/registrar/{user_id}', 'Api\UploadController@capaLoteList');

Route::post('/receber/validar-capa-lote', 'Api\ReceiveController@checkCapaLote')->name('receive.check-capa-lote');
Route::post('/capalote/contingencia', 'Api\CapaLoteController@_new')->name('capalote.api-new');
Route::get('/capalote/contingencia/{user_id}', 'Api\CapaLoteController@index')->name('capalote.api-index');

Route::get('/dashboard/envios/{user_id}', 'Api\DashboardController@toAgencyReport')->name('dashboard.envios');
Route::get('/dashboard/recebimentos/{user_id}', 'Api\DashboardController@fromAgencyReport')->name('dashboard.recebimentos');
Route::get('/dashboard/devolucoes/{user_id}', 'Api\DashboardController@returnAgencyReport')->name('dashboard.devolucoes');
Route::get('/arquivos/receber/{user_id}', 'Api\ReceiveController@fileList')->name('receive.lista-arquivos');
Route::get('/report/{file_id}/{user_id}/', 'Api\ReportController@fileContent')->name('report.arquivo');
Route::get('/recebimento/{user_id}', 'Api\CapaLoteController@getNotReceived')->name('capalote.get-not-received');
Route::get('/recebimento/{user_id}/{file_id}', 'Api\CapaLoteController@getNotReceived')->name('capalote.get-not-received-by-file');
Route::post('/doc/history/','Api\DocsHistoryController@getDocsHistory')->name('docshistory.get-doc-history');

// Agências
Route::group(['prefix' => '/agencias'], function () {
    Route::get('/listar', 'Api\AgenciasController@_list')->name('agencias.api-listar');
    Route::post('/', 'Api\AgenciasController@store')->name('agencias.api-adicionar');
    Route::put('/{id}', 'Api\AgenciasController@update')->name('agencias.api-atualizar');
    Route::delete('/{id}', 'Api\AgenciasController@destroy')->name('agencias.api-remover');
});