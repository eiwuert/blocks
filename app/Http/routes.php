<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index');
    Route::get('/simcard', 'SimcardController@index');
    Route::get('/buscar_simcard', 'SimcardController@buscar_simcard');
    Route::get('/actualizar_simcard', 'SimcardController@actualizar_simcard');
    Route::get('/eliminar_simcard', 'SimcardController@eliminar_simcard');
    Route::get('/asignar_responsable_paquete', 'SimcardController@asignar_responsable_paquete');
    Route::get('/buscar_paquete', 'SimcardController@buscar_paquete');
    Route::get('/empaquetar_simcard', 'SimcardController@empaquetar_simcard');
    Route::get('/crear_paquete', 'SimcardController@crear_paquete');
    Route::get('/eliminar_paquete', 'SimcardController@eliminar_paquete');
});
