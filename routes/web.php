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
Route::any('/', 'Auth\AuthController@index');
Route::any('/auth/login', 'Auth\AuthController@login')->name('auth.login');
Route::any('/auth/logout', 'Auth\AuthController@logout')->name('auth.logout');


Route::get('/dashboard', 'Dashboard\DashboardController@index');
// Route::get('/users/add', 'Users\UserController@create')->name('users.users_add');
// Route::get('/users/list', 'Users\UserController@index')->name('users.users_index');
// Route::get('/users/edit/{id}', 'Users\UserController@edit')->name('users.users_edit');

Route::get('/users/add', 'Api\UsersController@create')->name('users.users_add');
Route::get('/users/list', 'Api\UsersController@index')->name('users.users_index');
Route::get('/users/edit/{id}', 'Api\UsersController@edit')->name('users.users_edit');
Route::any('/users/update/{id}', 'Api\UsersController@update')->name('users.users_list');
Route::any('/users/delete/{id}', 'Api\UsersController@destroy')->name('users.users_delete');

Route::get('/auditoria', 'Api\AuditController@index')->name('audit.audit_list');
Route::get('/upload','Api\UploadController@index');
Route::get('/receber','Api\ReceiveController@index');
Route::get('/receber/{id}','Api\ReceiveController@list');

Route::group(['prefix' => 'cadastros'], function() {
	Route::get('produtos', 'Cadastros\CadastrosController@produtos');
	Route::get('produto/remove/{id}', 'Cadastros\CadastrosController@produto_remove');
	Route::get('produto/edit/{id}', 'Cadastros\CadastrosController@produto_edit');
	Route::get('contingencia', 'Cadastros\CadastrosController@contingencia');
});

Route::group(['prefix' => 'ocorrencias'], function() {
	Route::get('add', 'Cadastros\CadastrosController@alert_add');
	Route::get('list', 'Cadastros\CadastrosController@alert_list');
	Route::get('edit/{id}', 'Cadastros\CadastrosController@alert_edit');
	Route::get('remove/{id}', 'Cadastros\CadastrosController@alert_remove');
});

Route::get('/arquivos', 'Api\UploadController@arquivos')->name('uploads.upload_index');
Route::get('/arquivo/{id}', 'Api\UploadController@arquivo')->name('uploads.upload_edit');
Route::any('/arquivos/delete/{id}', 'Api\UploadController@removearquivo')->name('uploads.upload_delete');
Route::delete('/arquivo/recebe/{id}', 'Api\ReceiveController@check')->name('receive.receive_check');

Route::get('/remessa/registrar', 'Api\UploadController@registrar')->name('uploads.upload_register');
Route::get('/receber/registrar', 'Api\ReceiveController@registrar')->name('uploads.receive_register');
Route::get('/reports/remessa', 'Api\ReportController@remessa')->name('report.remessa');
Route::get('/arquivo-remessa/{id}', 'Api\ReportController@arquivo')->name('report.upload_edit');

Route::get('/receber-operador','Api\ReceiveController@operador');

Route::get('/upload/docs/{id}', 'Api\UploadController@docs');

Route::get('/receive/docs/{id}', 'Api\ReceiveController@docs');
