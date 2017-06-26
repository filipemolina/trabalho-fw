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

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::get('/configuracoes', 'HomeController@configuracoes');
Route::post('/trocarsenha', 'HomeController@trocarSenha');
Route::get('/fabrica', 'HomeController@fabrica');
Route::get('/curriculos-excluidos', 'CurriculosController@excluidos');
Route::post('/curriculos/{id}/restaurar', 'CurriculosController@restaurar');
Route::delete('/curriculos-excluidos/{id}', 'CurriculosController@excluir');
Route::post('/curriculos/encaminhar/', 'CurriculosController@encaminhar');
Route::get('/curriculos-encaminhados', 'CurriculosController@encaminhados');
Route::post('/curriculos/retornar/{id}', 'CurriculosController@retornar');

///////////////////////////////////////////////////// Rotas para o DataTables Server Side

Route::get('/curriculos/tabela', 'CurriculosController@dataTables');

///////////////////////////////////////////////////// Rotas para gerar PDF

Route::get('curriculos/pdf/{id}', 'CurriculosController@pdf');

///////////////////////////////////////////////////// Rotas para tela de relatorio

Route::get('/curriculos/relatorios/', 'CurriculosController@relatorios');
Route::post('/curriculos/imprimerelatorios', 'CurriculosController@imprimeRelatorio');

///////////////////////////////////////////////////// Registro de Resourceful Routes

Route::resource('curriculos', 'CurriculosController');
Route::resource('areas', 'AreasController');
Route::resource('usuarios', 'UsersController');
