<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();
Route::any('/', 'Auth\AuthController@index')->name('login');

Route::any('/auth/login', 'Auth\AuthController@login')->name('auth.login');
Route::any('/auth/logout', 'Auth\AuthController@logout')->name('auth.logout');


Route::get('/dashboard', 'Dashboard\DashboardController@index')->name('dashboard.index');
Route::get('/home', 'Dashboard\DashboardController@index')->name('home');

Route::group(['prefix' => 'users'], function() {
	Route::get('/add', 'Users\UserController@create')->name('users.users_add');
	Route::get('/list', 'Users\UserController@index')->name('users.users_index');
	Route::get('/edit/{id}', 'Users\UserController@edit')->name('users.users_edit');
	Route::any('/update/{id}', 'Api\UsersController@update')->name('users.users_list');
	Route::any('/delete/{id}', 'Api\UsersController@destroy')->name('users.users_delete');
    Route::post('/add', 'Users\UserController@store')->name('users.users_save');
	Route::get('/meus-dados', 'Users\UserController@myProfile')->name('users.my_profile');
    Route::put('/cadastro/atualizar', 'Users\UserController@updateMyProfile')->name('user.profile_update');
});

Route::get('/auditoria', 'Api\AuditController@index')->name('audit.audit_list');
Route::get('/upload','Api\UploadController@index');
Route::get('/receber','Api\ReceiveController@index');
Route::get('/receber/{id}','Api\ReceiveController@list');

Route::group(['prefix' => 'cadastros'], function() {
	Route::get('/produtos', 'Cadastros\CadastrosController@produtos');
	Route::get('/produto/remove/{id}', 'Cadastros\CadastrosController@produto_remove')->name('cadastros.delete_produto');
	Route::get('/produto/edit/{id}', 'Cadastros\CadastrosController@produto_edit')->name('cadastros.edit_produto');

	Route::get('/perfil', 'Cadastros\CadastrosController@perfis');
	Route::get('/perfil/remove/{id}', 'Cadastros\CadastrosController@perfil_remove')->name('cadastros.delete_profile');
	Route::get('/perfil/edit/{id}', 'Cadastros\CadastrosController@perfil_edit')->name('cadastros.edit_profile');

    Route::get('/agencias/', 'Agencias\AgenciasController@index')->name('agencias.index');
    Route::get('/agencias/adicionar', 'Agencias\AgenciasController@_new')->name('agencias.novo');
    Route::get('/agencias/editar/{agencia_id}', 'Agencias\AgenciasController@edit')->name('agencias.editar');
});

Route::group(['prefix' => 'ocorrencias'], function() {
	Route::get('/add', 'Cadastros\CadastrosController@alert_add');
	Route::get('/list', 'Cadastros\CadastrosController@alert_list')->name('cadastros.list_alert');
	Route::get('/edit/{id}', 'Cadastros\CadastrosController@alert_edit')->name('cadastros.edit_alert');
	Route::get('/remove/{id}', 'Cadastros\CadastrosController@alert_remove')->name('cadastros.delete_alert');;
});

Route::group(['prefix' => 'arquivos'], function() {
	Route::get('/', 'Api\UploadController@arquivos')->name('uploads.upload_index');
	Route::any('/delete/{id}', 'Api\UploadController@destroy')->name('uploads.upload_delete');
	Route::get('/edit/{id}', 'Api\UploadController@arquivo')->name('uploads.upload_edit');
});

Route::get('/arquivo/{id}', 'Api\UploadController@arquivo');
Route::any('/arquivo/delete/{id}', 'Api\UploadController@destroy');

Route::delete('/arquivo/recebe/{id}', 'Api\ReceiveController@check')->name('receive.receive_check');

Route::get('/remessa/registrar', 'Api\UploadController@registrar')->name('uploads.upload_register');
Route::get('/receber/registrar', 'Api\ReceiveController@registrar')->name('uploads.receive_register');
Route::get('/reports/remessa', 'Api\ReportController@remessa')->name('report.remessa');
Route::get('/arquivo-remessa/{id}', 'Api\ReportController@arquivo')->name('report.upload_edit');
Route::get('/report-remessa/{id}', 'Api\ReportController@arquivo')->name('uploads.report');

Route::get('/receber-operador','Api\ReceiveController@operador');
Route::get('/doc/history/{id}','Api\UploadController@history');

Route::get('/receber-todos/','Api\ReceiveController@docListingIndex');

Route::group(['prefix' => 'capalote'], function() {
	Route::get('ver', 'CapaLote\CapaLoteController@show')->name('capalote.show');
    Route::get('contingencia', 'CapaLote\CapaLoteController@index')->name('capalote.index');
    Route::post('contingencia', 'CapaLote\CapaLoteController@_new')->name('capalote.new');
	Route::get('contingencia/imprimir/{doc_id}', 'CapaLote\CapaLoteController@showPDF')->name('capalote.imprimir');
	Route::post('contingencia/imprimir/', 'CapaLote\CapaLoteController@showPDFMultiple')->name('capalote.imprimir-multiplo');
});

Route::group(['prefix' => 'cadastros/unidades'], function() {
    Route::get('/', 'Unidade\UnidadeController@index')->name('unidades.index');
    Route::get('/adicionar', 'Unidade\UnidadeController@_new')->name('unidade.novo');
    Route::get('/editar/{agencia_id}', 'Unidade\UnidadeController@edit')->name('unidade.editar');
    Route::post('/', 'Unidade\UnidadeController@store')->name('unidade.adicionar');
});

Route::group(['prefix' => 'a'], function() {
	Route::get('/consultar/capalote', 'Anon\AnonController@checkCapaLote')->name('anon.check_capalote');
	Route::post('/ver/capalote', 'Anon\AnonController@getCapaLoteHistory')->name('anon.get_capalote_history');
	Route::get('/ver/capalote', 'Anon\AnonController@showCapaLoteHistory')->name('anon.show_capalote_history');
	Route::post('/imprimir/capalote', 'CapaLote\CapaLoteController@showPDFMultiple')->name('anon.print_capalote');

});