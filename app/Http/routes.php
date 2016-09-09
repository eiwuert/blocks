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

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

// Control vendedores
Route::get('/control', 'ActorController@control_vendedores_front');
Route::get('/guardar_ubicacion', 'ActorController@guardar_ubicacion');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index');
    
    //PAGINAS PRINCIPALES
    
    Route::get('/simcard', ['as' => 'simcard', 'uses' => 'SimcardController@index']);
    Route::get('/cliente', 'ClienteController@index');
    Route::get('/equipo', ['as' => 'equipo', 'uses' => 'EquipoController@index']);
    Route::get('/fija', ['as' => 'fija', 'uses' => 'FijaController@index']);
    Route::get('/personal', 'ActorController@index');
    Route::get('/control_vendedores', 'ActorController@control_vendedores');    
    Route::get('/cartera', 'CarteraController@index');
    Route::get('/comision', ['as' => 'comision', 'uses' => 'ComisionController@index']);
    
    // ACCIONES SIMCARDS
    
    Route::get('/buscar_simcard', 'SimcardController@buscar_simcard');
    Route::get('/actualizar_simcard', 'SimcardController@actualizar_simcard');
    Route::get('/eliminar_simcard', 'SimcardController@eliminar_simcard');
    Route::get('/asignar_responsable_paquete', 'SimcardController@asignar_responsable_paquete');
    Route::get('/buscar_paquete', 'SimcardController@buscar_paquete');
    Route::get('/empaquetar_simcard', 'SimcardController@empaquetar_simcard');
    Route::get('/desempaquetar_simcard', 'SimcardController@desempaquetar_simcard');
    Route::get('/crear_paquete', 'SimcardController@crear_paquete');
    Route::get('/eliminar_paquete', 'SimcardController@eliminar_paquete');
    Route::post('/subir_archivo_simcards', ['as' => 'subirArchivoSimcards', 'uses' => 'SimcardController@subir_archivo']);
    Route::get('/legalizar_venta', 'SimcardController@legalizar_venta');
    Route::get('/buscar_venta', 'SimcardController@buscar_venta');
    
    // ACCIONES PLANES
    Route::get('/buscar_plan', 'PlanController@buscar_plan');
    Route::get('/crear_plan', 'PlanController@crear_plan');
    Route::get('/actualizar_plan', 'PlanController@actualizar_plan');
    Route::get('/eliminar_plan', 'PlanController@eliminar_plan');
    Route::post('/subir_archivo_planes', ['as' => 'subirArchivoPlanes', 'uses' => 'PlanController@subir_archivo']);
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
    Route::get('/actualizar_equipo_general', 'EquipoController@actualizar_equipo_general');
    Route::get('/actualizar_equipo_especifico', 'EquipoController@actualizar_equipo_especifico');
    Route::get('/eliminar_equipo_especifico', 'EquipoController@eliminar_equipo_especifico');
    Route::get('/eliminar_equipo_general', 'EquipoController@eliminar_equipo_general');
    Route::post('/subir_archivo_equipos', ['as' => 'subirArchivoEquipo', 'uses' => 'EquipoController@subir_archivo_equipo']);
    Route::post('/subir_archivo_descripcion_equipos', ['as' => 'subirArchivoDescripcionEquipo', 'uses' => 'EquipoController@subir_archivo_descripcion']);
    
    Route::get('/asignar_responsable_equipo', 'EquipoController@asignar_responsable_equipo');
    
    // ACCIONES EMPLEADOS
    Route::get('/buscar_actor', 'ActorController@buscar_actor');
    Route::get('/crear_actor', 'ActorController@crear_actor');
    Route::get('/actualizar_actor', 'ActorController@actualizar_actor');
    Route::get('/eliminar_actor', 'ActorController@eliminar_actor');
    Route::get('/buscar_ubicaciones', 'ActorController@buscar_ubicaciones');
    
    // ACCIONES SERVICIOS
    Route::get('/buscar_fija', 'FijaController@buscar_fija');
    Route::post('/subir_archivo_fija', ['as' => 'subirArchivoFija', 'uses' => 'FijaController@subir_archivo']);
    
    // ACCIONES CARTERA
    Route::get('/buscar_cartera', 'CarteraController@buscar_cartera');
    Route::get('/obtener_registro_cartera', 'CarteraController@obtener_registro');
    Route::get('/crear_registro', 'CarteraController@crear_registro');
    Route::get('/eliminar_registro', 'CarteraController@eliminar_registro');
    Route::get('/actualizar_registro', 'CarteraController@actualizar_registro');
    
    // ACCIONES USUARIO
    Route::get('/ver_notificacion', 'ActorController@ver_notificacion');
    
    // ACCIONES REPORTES
    Route::get('/reportes_inventario', 'ReporteController@reportes_inventario');
    Route::get('/reportes_personal', 'ReporteController@reportes_personal');
    
    // ACCIONES SEGURIDAD
    Route::get('/permisos', 'SeguridadController@permisos');
    Route::get('/guardar_permisos', 'SeguridadController@guardar_permisos');
    
    // ACCIONES COMISIONES
    Route::get('/buscar_comision', 'ComisionController@buscar_comision');
    Route::get('/detalle_comision_prepago', 'ComisionController@detalle_comision_prepago');
    Route::get('/detalle_comision_libre', 'ComisionController@detalle_comision_libre');
    Route::get('/detalle_comision_postpago', 'ComisionController@detalle_comision_postpago');
    Route::post('/subir_archivo_comisiones', ['as' => 'subirComisiones', 'uses' => 'ComisionController@subir_archivo']);
});
