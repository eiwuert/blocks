<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\Equipo;
use App\Simcard;
use App\Descripcion_Equipo;
use App\Http\Controllers\Controller;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $equipo = $request["equipo"];
        $data = array();
        $Actor = Auth::user()->actor;
        $Actor_nombre = $Actor->nombre;
        $data['Actor_nombre'] = $Actor_nombre;
        $data['Cantidad_notificaciones'] = 0;
        $data["equipo"] = $equipo;
        return View('equipo', $data);
    }
    
    public function buscar_equipo_general(Request $request){
        $pista = $request["dato"];
        $descripcion_equipo = Descripcion_Equipo::where('cod_scl',$pista)->orWhere('modelo',$pista)->first();
        if($descripcion_equipo != null){
            $descripcion_equipo->equipos = $descripcion_equipo->equipos;
        }
        return $descripcion_equipo;
    }
    
    public function buscar_equipo_especifico(Request $request){
        $pista = $request["dato"];
        $equipo = Equipo::find($pista);
        if($equipo != null){
            $equipo->descripcion_equipo = $equipo->descripcion_equipo;
            if($equipo->cliente != null){
                $equipo->cliente = $equipo->cliente;
            }
            if($equipo->simcard != null){
                $equipo->simcard = $equipo->simcard;
                $equipo->color = Simcard::color_estado($equipo->simcard);
            }
        }
        return $equipo;
    }
    
    public function actualizar_equipo_general(Request $request){
        $datos_equipo_general = $request["dato"];
        $cod_copia = $datos_equipo_general["cod_scl_copia"];
        $nuevo_cod = $datos_equipo_general["Equipo_cod_scl"];
        if($cod_copia != $nuevo_cod){
            $equipo = Descripcion_Equipo::find($nuevo_cod);
            if($equipo != null){
                return "El codigo ya se encuentra registrado";
            }else{
                $equipo = Descripcion_Equipo::find($cod_copia);
                $equipo->delete();
                $equipo = new Descripcion_Equipo();
                $equipo->cod_scl = $nuevo_cod;
            }
        }else{
            $equipo = Descripcion_Equipo::find($cod_copia);
            if($equipo == null){
                return "No se encuentra el código";
            }
        }
        $equipo->gama = $datos_equipo_general["Equipo_gama"];
        $equipo->marca = $datos_equipo_general["Equipo_marca"];
        $equipo->modelo = $datos_equipo_general["Equipo_modelo"];
        $equipo->precio_prepago = $datos_equipo_general["Equipo_precio_prepago"];
        $equipo->precio_postpago = $datos_equipo_general["Equipo_precio_postpago"];
        $equipo->precio_3_cuotas = $datos_equipo_general["Equipo_precio_3_cuotas"];
        $equipo->precio_6_cuotas = $datos_equipo_general["Equipo_precio_6_cuotas"];
        $equipo->precio_9_cuotas = $datos_equipo_general["Equipo_precio_9_cuotas"];
        $equipo->precio_12_cuotas = $datos_equipo_general["Equipo_precio_12_cuotas"];
        if($equipo->save()){
            return "EXITOSO";
        }else{
            return "Error al guardar datos";
        }
    }
    
    public function actualizar_equipo_especifico(Request $request){
        $datos_equipo_especifico = $request["dato"];
        $IMEI_copia = $datos_equipo_especifico["Equipo_IMEI_copia"];
        $nuevo_IMEI = $datos_equipo_especifico["Equipo_IMEI"];
        if($IMEI_copia != $nuevo_IMEI){
            $equipo = Equipo::find($nuevo_IMEI);
            if($equipo != null){
                return "El IMEI ya se encuentra registrado";
            }else{
                $equipo = new Equipo();
                $equipo->IMEI = $nuevo_IMEI;
                $equipo_aux = Equipo::find($IMEI_copia);
                $equipo->Descripcion_Equipo_cod_scl = $equipo_aux->Descripcion_Equipo_cod_scl;
                $equipo_aux->delete();
            }
        }else{
            $equipo = Equipo::find($IMEI_copia);
            if($equipo == null){
                return "No se encuentra el código";
            }
        }
        $equipo->fecha_venta = $datos_equipo_especifico["Equipo_fecha_venta"];
        $equipo->descripcion_precio = $datos_equipo_especifico["Equipo_descripcion_precio"];
        if($equipo->save()){
            return "EXITOSO";
        }else{
            return "Error al guardar datos";
        }
    }
}
