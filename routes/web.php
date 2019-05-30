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


Route::get('/painel', 'Dashboard\DashboardController@index')->name('painel');
Route::get('/home', 'Dashboard\DashboardController@index')->name('home');

Route::group(['prefix' => 'usuarios'], function() {
	Route::get('/novo', 'Users\UserController@create')->name('usuarios.novo');
	Route::get('/listar', 'Users\UserController@index')->name('usuarios.listar');
	Route::get('/edit/{id}', 'Users\UserController@edit')->name('users.users_edit');
	Route::any('/update/{id}', 'Api\UsersController@update')->name('users.users_list');
	Route::any('/delete/{id}', 'Api\UsersController@destroy')->name('users.users_delete');
    Route::post('/add', 'Users\UserController@store')->name('users.users_save');
	Route::get('/meus-dados', 'Users\UserController@myProfile')->name('users.my_profile');
    Route::put('/cadastro/atualizar', 'Users\UserController@updateMyProfile')->name('user.profile_update');
});

Route::get('/auditoria', 'Api\AuditController@index')->name('auditoria.listar');

Route::get('/receber/{id}','Api\ReceiveController@_list');

Route::group(['prefix' => 'cadastros'], function() {
	Route::get('/produtos', 'Cadastros\CadastrosController@produtos')->name('cadastro.produtos');
	Route::get('/produto/remove/{id}', 'Cadastros\CadastrosController@produto_remove')->name('cadastros.delete_produto');
	Route::get('/produto/edit/{id}', 'Cadastros\CadastrosController@produto_edit')->name('cadastros.edit_produto');

	Route::get('/perfil', 'Cadastros\CadastrosController@perfis')->name('cadastro.perfis');
	Route::get('/perfil/remove/{id}', 'Cadastros\CadastrosController@perfil_remove')->name('cadastros.delete_profile');
	Route::get('/perfil/edit/{id}', 'Cadastros\CadastrosController@perfil_edit')->name('cadastros.edit_profile');

    Route::get('/agencias', 'Agencias\AgenciasController@index')->name('cadastro.agencias');
    Route::get('/agencias/adicionar', 'Agencias\AgenciasController@_new')->name('agencias.novo');
    Route::put('/agencias/adicionar', 'Agencias\AgenciasController@store');
    Route::get('/agencias/editar/{agencia_id}', 'Agencias\AgenciasController@edit')->name('agencias.editar');

    Route::get('/unidades', 'Unidade\UnidadeController@index')->name('cadastro.unidades');
    Route::get('/unidades/adicionar', 'Unidade\UnidadeController@_new')->name('unidade.novo');
    Route::get('/unidades/editar/{agencia_id}', 'Unidade\UnidadeController@edit')->name('unidade.editar');
    Route::post('/unidades/', 'Unidade\UnidadeController@store')->name('unidade.adicionar');
});

Route::group(['prefix' => 'ocorrencias'], function() {
	Route::get('/add', 'Cadastros\CadastrosController@alert_add');
	Route::get('/listagem', 'Cadastros\CadastrosController@alert_list')->name('ocorrencias.listagem');
	Route::get('/edit/{id}', 'Cadastros\CadastrosController@alert_edit')->name('cadastros.edit_alert');
	Route::get('/remove/{id}', 'Cadastros\CadastrosController@alert_remove')->name('cadastros.delete_alert');;
});

Route::group(['prefix' => 'arquivos'], function() {
	Route::any('/delete/{id}', 'Api\UploadController@destroy')->name('uploads.upload_delete');
	Route::get('/edit/{id}', 'Api\UploadController@arquivo')->name('uploads.upload_edit');
	Route::get('/{file_id}', 'Arquivo\ArquivoController@file')->name('arquivo.file');
});

Route::get('/arquivo/{id}', 'Api\UploadController@arquivo');
Route::any('/arquivo/delete/{id}', 'Api\UploadController@destroy');

Route::delete('/arquivo/recebe/{id}', 'Api\ReceiveController@check')->name('receive.receive_check');

Route::group(['prefix' => 'remessa'], function() {
	Route::get('/arquivos', 'Arquivo\ArquivoController@listagemRemessa')->name('remessa.listagem');
    Route::get('/registrar', 'Remessa\RemessaController@registrar')->name('remessa.registrar');
    Route::get('/carregar','Api\UploadController@index')->name('remessa.carregar');
});

Route::get('/receber/registrar', 'Api\ReceiveController@registrar')->name('uploads.receive_register');

Route::group(['prefix' => 'relatorios'], function() {
	Route::get('/remessa', 'Api\ReportController@remessa')->name('relatorios.remessa');
	Route::get('/analitico', 'Relatorios\RelatoriosController@analytic')->name('relatorios.analitico');
	Route::post('/analitico/export', 'Relatorios\RelatoriosController@exportAnalytic')->name('relatorios.analytic-export');
	Route::get('/analitico/export/{code}', 'Relatorios\RelatoriosController@downloadAnalyticReport')->name('relatorios.analytic-export-download');
});

Route::get('/arquivo-remessa/{id}', 'Api\ReportController@arquivo')->name('report.upload_edit');
Route::get('/report-remessa/{id}', 'Api\ReportController@arquivo')->name('uploads.report');

Route::group(['prefix' => 'recebimento'], function() {
    Route::get('/agencia','Api\ReceiveController@index')->name('recebimento.agencia');
    Route::get('/operador', 'Recebimento\RecebimentoController@operador')->name('recebimento.operador');
	Route::get('/carregar-arquivo', 'Recebimento\RecebimentoController@carregarArquivoLeituras')->name('recebimento.carregar-arquivo');
    Route::get('/todos','Api\ReceiveController@docListingIndex')->name('recebimento.todos');
});

Route::get('/doc/history/{id}', 'Api\UploadController@history');

Route::group(['prefix' => 'capalote'], function() {
	Route::get('/ver', 'CapaLote\CapaLoteController@show')->name('capalote.show');
	Route::any('/buscar', 'CapaLote\CapaLoteController@find')->name('capalote.buscar');
    Route::get('/contingencia', 'CapaLote\CapaLoteController@contingencia')->name('capalote.contingencia');
    Route::get('/listar', 'CapaLote\CapaLoteController@index')->name('capalote.listar');
    Route::post('/contingencia', 'CapaLote\CapaLoteController@_new')->name('capalote.new');
	Route::get('/contingencia/imprimir/{doc_id}', 'CapaLote\CapaLoteController@showPDF')->name('capalote.imprimir');
	Route::post('/contingencia/imprimir/', 'CapaLote\CapaLoteController@showPDFMultiple')->name('capalote.imprimir-multiplo');
});

Route::group(['prefix' => 'a'], function() {
	Route::get('/consultar/capalote', 'Anon\AnonController@checkCapaLote')->name('anon.check_capalote');
	Route::get('/ver/capalote', 'Anon\AnonController@showCapaLoteHistory')->name('anon.show_capalote_history');
	Route::post('/imprimir/capalote', 'CapaLote\CapaLoteController@showPDFMultiple')->name('anon.print_capalote');
});