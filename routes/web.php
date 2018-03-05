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

/*Route::get('/', function () {
    return view('welcome');
});*/

//Route::get('/', 'LoginController@index');

//Route::view('/login','login');

Route::name('login_program')->get('/','loginController@index');
Route::name('iniciar')->get('iniciar', 'loginController@iniciar');

Route::name('validar_sesion')->post('validar_sesion', 'loginController@validar_sesion');