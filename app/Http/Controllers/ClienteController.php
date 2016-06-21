<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Actor;
use App\Simcard;
use App\Cliente;
use Auth;
use App\Http\Controllers\Controller;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $Actor = Auth::user()->actor;
        $Actor_nombre = $Actor->nombre;
        $data['Actor_nombre'] = $Actor_nombre;
        $data['Cantidad_notificaciones'] = 0;
        return View('cliente',$data);
    }

    public function buscar_cliente(Request $request){
        $pista = $request["dato"];
        $cliente = Cliente::where('identificacion','=',$pista)->orWhere('nombre', 'like' , '%' . $pista . '%')->first();
        if($cliente != null){
            $cliente->responsable = $cliente->responsable;
            $cliente->simcards = $cliente->simcards;
            foreach ($cliente->simcards as &$simcard){
                $simcard->color = Simcard::color_estado($simcard);
            }
        }
        return $cliente;
    }
    
    public function crear_cliente(Request $request){
        $datos_cliente = $request["dato"];
        $cliente = new Cliente();
        $cliente->identificacion = $datos_cliente["Cliente_identificacion"];
        $cliente->tipo = $datos_cliente["Cliente_tipo"];
        $cliente->nombre = $datos_cliente["Cliente_nombre"];
        $cliente->telefono = $datos_cliente["Cliente_telefono"];
        $cliente->correo = $datos_cliente["Cliente_correo"];
        if($cliente->save()){
            return "EXITOSO";
        }else{
            return "ERROR AL GUARDAR EL CLIENTE";
        }
    }
}
