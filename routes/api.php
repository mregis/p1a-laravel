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
    Route::get('/list/{user_id}', 'Api\UsersController@listUsers')->name('users.get_users_list');
    Route::post('/', 'Api\UsersController@store')->name('users.api-store');
    Route::get('/{id}', 'Api\UsersController@show');
    Route::put('/meus-dados', 'Api\UsersController@updateMyProfile')->name('users.profile_update');
    Route::put('/{id}', 'Api\UsersController@update')->name('users.users_update');
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

Route::get('/audit/list', 'Api\AuditController@listAudit')->name('audit.list');


Route::post('/products/', 'Api\ProductsController@store');

// Upload Group
Route::group(['prefix' => '/upload'], function () {
    Route::post('/{user_id}', 'Api\UploadController@index');
    Route::get('/list', 'Api\UploadController@listFiles')->name('upload.list');
    Route::delete('/delete/{file_id}', 'Api\UploadController@destroy')->name('upload.delete');
    Route::get('/docs/{id}/{profile}/{juncao}', 'Api\UploadController@docs');
    Route::get('/docs/{id}/{profile}', 'Api\UploadController@docs');
    Route::get('/report/{id}/{profile}/{juncao}', 'Api\UploadController@report');
    Route::get('/report/{id}/{profile}', 'Api\UploadController@report');
    Route::delete('/{id}', 'Api\UploadController@destroy');

});


Route::get('/receive/docs/{id}/{profile}/{juncao}', 'Api\ReceiveController@docs');
Route::get('/receive/docs/{id}/{profile}', 'Api\ReceiveController@docs');

Route::post('/remessa/registrar', 'Api\UploadController@register');
Route::post('/receber/registrar', 'Api\ReceiveController@register');
Route::post('/receber/registraroperador', 'Api\ReceiveController@registeroperador')->name('receive.register-capa-lote');

// Relatórios
Route::group(['prefix' => '/report'], function () {
    Route::get('/list/{user_id}', 'Api\ReportController@_list')->name('report.list');
    Route::get('/docs/{id}', 'Api\ReportController@docs');
    Route::any('/analytics', 'Api\DocsHistoryController@getDocsHistoryAnalyticReport')->name('report.analytic');
    Route::any('/analytics/list', 'Api\AnalyticsReportController@_list')->name('relatorios.analytics-report-list');
    Route::delete('/analytics/{id}', 'Api\AnalyticsReportController@_delete')->name('relatorios.analytics-report-delete');
});

Route::post('/contingencia', 'Api\UploadController@contingencia');

Route::post('/perfil/', 'Api\ProfileController@store');

Route::get('/receber-todos/{profile}/{juncao}', 'Api\ReceiveController@doclisting');
Route::get('/receber-todos/{profile}', 'Api\ReceiveController@doclisting');
Route::get('/remessa/registrar/{user_id}', 'Api\UploadController@capaLoteList');

Route::post('/receber/validar-capa-lote', 'Api\ReceiveController@checkCapaLote')->name('receive.check-capa-lote');

Route::group(['prefix' => '/recebimento'], function () {
    Route::post('/remover-leitura', 'Api\ReceiveController@removeLeitura')->name('recebimento.remove-leitura');
    Route::post('/carregar-leituras', 'Api\ReceiveController@carregarLeituras')->name('recebimento.carregar-leituras');
    Route::post('/gerar-num-lote', 'Api\ReceiveController@gerarNumLote')->name('recebimento.gerar-num-lote');

});
// Capa de Lote
Route::group(['prefix' => '/capalote'], function () {
    Route::get('/list/{user_id}', 'Api\CapaLoteController@_list')->name('capalote.list');
    Route::post('/contingencia', 'Api\CapaLoteController@_new')->name('capalote.api-new');
    Route::get('/contingencia/list/{user_id}', 'Api\CapaLoteController@list_contigencia')->name('capalote.list_contingencia');
});
// Dashboard
Route::group(['prefix' => '/dashboard'], function () {
    Route::get('/envios/{user_id}', 'Api\DashboardController@toAgencyReport')->name('dashboard.envios');
    Route::get('/recebimentos/{user_id}', 'Api\DashboardController@fromAgencyReport')->name('dashboard.recebimentos');
    Route::get('/devolucoes/{user_id}', 'Api\DashboardController@returnAgencyReport')->name('dashboard.devolucoes');
    Route::get('/report/{user_id}', 'Api\DashboardController@report')->name('dashboard.report');
});

Route::group(['prefix' => '/arquivos'], function () {
    Route::get('/receber/{user_id}', 'Api\ReceiveController@fileList')->name('receive.lista-arquivos');
    Route::get('/{file_id}/list/{user_id}', 'Api\ReportController@fileContent')->name('report.file_content');
});
Route::get('/report/{file_id}/{user_id}/', 'Api\ReportController@fileContent')->name('report.arquivo');
Route::get('/recebimento/{user_id}', 'Api\CapaLoteController@getNotReceived')->name('capalote.get-not-received');
Route::get('/recebimento/{user_id}/{file_id}', 'Api\CapaLoteController@getNotReceived')->name('capalote.get-not-received-by-file');
Route::post('/doc/history/','Api\DocsHistoryController@getDocsHistory')->name('docshistory.get-doc-history');

// Agências
Route::group(['prefix' => '/agencias'], function () {
    Route::get('/listar', 'Api\AgenciasController@_list')->name('agencias.api-listar');
    Route::get('/search', 'Api\AgenciasController@prefetchList')->name('agencias.api-buscar');
    Route::post('/', 'Api\AgenciasController@store')->name('agencias.api-adicionar');
    Route::put('/{id}', 'Api\AgenciasController@update')->name('agencias.api-atualizar');
    Route::delete('/{id}', 'Api\AgenciasController@destroy')->name('agencias.api-remover');
});

// Unidades
Route::group(['prefix' => '/unidades'], function () {
    Route::get('/listar', 'Api\UnidadeController@_list')->name('unidades.api-listar');
    Route::post('/', 'Api\UnidadeController@store')->name('unidade.api-adicionar');
    Route::put('/{id}', 'Api\UnidadeController@update')->name('unidade.api-atualizar');
    Route::delete('/{id}', 'Api\UnidadeController@destroy')->name('unidade.api-remover');
});

Route::get('/capalote/arquivo/{user_id}/{file_id}', 'Api\CapaLoteController@report')->name('capalote.file_report');

Route::group(['prefix' => 'ocorrencias'], function() {
    Route::put('/edit/{id}', 'Api\AlertsController@update')->name('alerts.api_edit_alert');
    Route::get('/list', 'Api\AlertsController@listAlerts')->name('alerts.list');
});