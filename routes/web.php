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

///////////////////////////////////////////////////// Rotas para gerar PDF

Route::get('curriculos/pdf/{id}', 'CurriculosController@pdf');

///////////////////////////////////////////////////// Registro de Resourceful Routes

Route::resource('curriculos', 'CurriculosController');
Route::resource('areas', 'AreasController');
Route::resource('usuarios', 'UsersController');
