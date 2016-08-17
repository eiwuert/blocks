<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Actor;
use App\Responsable_Empresa;
use App\Simcard;
use App\Cliente;
use App\Ubicacion;
use Auth;
use App\Http\Controllers\Controller;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cliente = $request["cliente"];
        $data = array();
        $data['Actor'] = Auth::user()->actor;
        // CARGAR NOTIFICACIONES
        $data['notificaciones'] = Notificacion::where("Actor_cedula",$actor->cedula)->get();
        $data["cliente"] = $cliente;    
        $regiones = Ubicacion::select('region')->distinct()->get();
        foreach ($regiones as &$region) {
            $region->ciudades = Ubicacion::select('ciudad')->where('region',$region->region)->get();
        }
        $data["regiones"] = $regiones;
        return View('general.cliente',$data);
    }

    public function buscar_cliente(Request $request){
        $pista = $request["dato"];
        $cliente = Cliente::where('identificacion','like','%' . $pista . '%')->orWhere('nombre', 'like' , '%' . $pista . '%')->first();
        if($cliente != null){
            $cliente->responsable = $cliente->responsable;
            $cliente->simcards = $cliente->simcards;
            foreach ($cliente->simcards as &$simcard){
                $simcard->color = Simcard::color_estado($simcard);
            }
            $cliente->equipos = $cliente->equipos;
            $cliente->ubicacion = $cliente->ubicacion;
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
        $cliente->direccion = $datos_cliente["Cliente_direccion"];
        //ASIGNAR UBICACION
        if($datos_cliente["Cliente_region"] != "Región"){
            $ubicacion = Ubicacion::where("region",$datos_cliente["Cliente_region"])->where("ciudad",$datos_cliente["Cliente_ciudad"])->first();
            if($ubicacion != null){
                $cliente->Ubicacion_ID = $ubicacion->ID;
            }
        }
        if($cliente->save()){
            return "EXITOSO";
        }else{
            return "ERROR AL GUARDAR EL CLIENTE";
        }
    }
    
    public function actualizar_cliente(Request $request){
        $datos_cliente = $request["dato"];
        if($datos_cliente["Cliente_identificacion"] != $datos_cliente["identificacion_copia"]){
            $cliente = Cliente::find($datos_cliente["Cliente_identificacion"]);
            if($cliente != null){
                return "EL CÓDIGO YA SE ENCUENTRA REGISTRADO";
            }else{
                $cliente = Cliente::find($datos_cliente["identificacion_copia"]);
                if($cliente != null){
                    $cliente_nuevo = new Cliente();
                    $cliente_nuevo->identificacion = $datos_cliente["Cliente_identificacion"];
                    $cliente_nuevo->tipo = $datos_cliente["Cliente_tipo"];
                    $cliente_nuevo->nombre = $datos_cliente["Cliente_nombre"];
                    $cliente_nuevo->telefono = $datos_cliente["Cliente_telefono"];
                    $cliente_nuevo->correo = $datos_cliente["Cliente_correo"];
                    $cliente_nuevo->direccion = $datos_cliente["Cliente_direccion"];
                    //ASIGNAR UBICACION
                    if($datos_cliente["Cliente_region"] != "Región"){
                        $ubicacion = Ubicacion::where("region",$datos_cliente["Cliente_region"])->where("ciudad",$datos_cliente["Cliente_ciudad"])->first();
                        if($ubicacion != null){
                            $cliente->Ubicacion_ID = $ubicacion->ID;
                        }
                    }
                    if($cliente_nuevo->save()){
                        $simcards = $cliente->simcards;
                        foreach ($simcards as &$simcard) {
                            $simcard->Cliente_identificacion = $datos_cliente["Cliente_identificacion"];
                            $simcard->save();
                        }
                        $responsable = $cliente->responsable;
                        if($responsable != null){
                            $responsable->Cliente_identificacion = $datos_cliente["Cliente_identificacion"];
                            $responsable->save();
                        }
                        $cliente->delete();
                        return "EXITOSO";
                    }else{
                        return "ERROR AL GUARDAR EL CLIENTE";
                    }
                }else{
                    return "ERROR AL GUARDAR EL CLIENTE";
                }
            }
        }else{
            $cliente = Cliente::find($datos_cliente["identificacion_copia"]);
            if($cliente != null){
                $cliente->tipo = $datos_cliente["Cliente_tipo"];
                $cliente->nombre = $datos_cliente["Cliente_nombre"];
                $cliente->telefono = $datos_cliente["Cliente_telefono"];
                $cliente->correo = $datos_cliente["Cliente_correo"];
                $cliente->direccion = $datos_cliente["Cliente_direccion"];
                //ASIGNAR UBICACION
                if($datos_cliente["Cliente_region"] != "Región"){
                    $ubicacion = Ubicacion::where("region",$datos_cliente["Cliente_region"])->where("ciudad",$datos_cliente["Cliente_ciudad"])->first();
                    if($ubicacion != null){
                        $cliente->Ubicacion_ID = $ubicacion->ID;
                    }
                }
                if($cliente->save()){
                    return "EXITOSO";
                }else{
                    return "ERROR AL GUARDAR EL CLIENTE";
                }
            }else{
                return "ERROR AL GUARDAR EL CLIENTE";
            }
        }
    }
    
    public function eliminar_cliente(Request $request){
        $datos_cliente = $request["dato"];
        $cliente = Cliente::find($datos_cliente);
        if($cliente != null){
            $simcards = $cliente->simcards;
            foreach ($simcards as &$simcard) {
                $simcard->Cliente_identificacion = null;
                $simcard->save();
            }
            $responsable = $cliente->responsable;
            if($responsable != null){
                $responsable->delete();
            }
            $cliente->delete();
            return "EXITOSO";
        }else{
            return "ERROR AL GUARDAR EL CLIENTE";
        }
    }
    
    public function actualizar_responsable(Request $request){
        $datos_responsable = $request["dato"];
        $responsable = Responsable_Empresa::where("Cliente_identificacion","=", $datos_responsable["Cliente_identificacion"])->first();
        if($responsable == null){
            $responsable = new Responsable_Empresa();
        }
        $responsable->Cliente_identificacion = $datos_responsable["Cliente_identificacion"];
        $responsable->cedula = $datos_responsable["Responsable_cedula"];
        $responsable->nombre = $datos_responsable["Responsable_nombre"];
        $responsable->telefono = $datos_responsable["Responsable_telefono"];
        $responsable->correo = $datos_responsable["Responsable_correo"];
        if($responsable->save()){
            return "EXITOSO";
        }else {
            return "ERROR AL ACTUALIZAR";
        }
    }
    
    public function eliminar_responsable(Request $request){
        $Responsable_cedula = $request["dato"];
        $responsable = Responsable_Empresa::find($Responsable_cedula);
        if($responsable == null){
            return "EXITOSO";
        }
        if($responsable->delete()){
            return "EXITOSO";
        }else {
            return "ERROR AL ELIMINAR";
        }
    }
}
