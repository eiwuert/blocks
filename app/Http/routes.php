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
    
    //PAGINAS PRINCIPALES
    
    Route::get('/simcard', 'SimcardController@index');
    Route::get('/cliente', 'ClienteController@index');
    Route::get('/equipo', 'EquipoController@index');
    
    // ACCIONES SIMCARDS
    
    Route::get('/buscar_simcard', 'SimcardController@buscar_simcard');
    Route::get('/actualizar_simcard', 'SimcardController@actualizar_simcard');
    Route::get('/eliminar_simcard', 'SimcardController@eliminar_simcard');
    Route::get('/asignar_responsable_paquete', 'SimcardController@asignar_responsable_paquete');
    Route::get('/buscar_paquete', 'SimcardController@buscar_paquete');
    Route::get('/empaquetar_simcard', 'SimcardController@empaquetar_simcard');
    Route::get('/crear_paquete', 'SimcardController@crear_paquete');
    Route::get('/eliminar_paquete', 'SimcardController@eliminar_paquete');
    
    // ACCIONES PLANES
    Route::get('/buscar_plan', 'PlanController@buscar_plan');
    Route::get('/crear_plan', 'PlanController@crear_plan');
    Route::get('/actualizar_plan', 'PlanController@actualizar_plan');
    Route::get('/eliminar_plan', 'PlanController@eliminar_plan');
    
    // ACCIONES CLIENTES
    
    Route::get('/buscar_cliente', 'ClienteController@buscar_cliente');
    Route::get('/crear_cliente', 'ClienteController@crear_cliente');
    Route::get('/actualizar_cliente', 'ClienteController@actualizar_cliente');
    Route::get('/eliminar_cliente', 'ClienteController@eliminar_cliente');
    Route::get('/actualizar_responsable', 'ClienteController@actualizar_responsable');
    Route::get('/eliminar_responsable', 'ClienteController@eliminar_responsable');
    
    // ACCIONES EQUIPOS
    Route::get('/buscar_equipo_general', 'EquipoController@buscar_equipo_general');
    Route::get('/buscar_equipo_especifico', 'EquipoController@buscar_equipo_especifico');
});
