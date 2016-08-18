<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\Equipo;
use DateTime;
use App\Actor;
use Excel;
use Queue;
use App\Simcard;
use App\Asignacion_Permiso;
use App\Descripcion_Equipo;
use App\Notificacion;
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
        $data['Actor'] = $Actor;
        // CARGAR NOTIFICACIONES
        $data['notificaciones'] = Notificacion::where("Actor_cedula",$Actor->cedula)->get();
        $data["equipo"] = $equipo;
        // OBTENER POSIBLES RESPONSABLES
        $responsables = Actor::all();
        $data["responsables"] = $responsables;
        // OBTENER PERMISO
        $permiso = Asignacion_Permiso::where("User_email",Auth::user()->email)->where("permiso", "INVENTARIOS")->first();
        if($permiso != null || Auth::user()->actor->jefe_cedula == null){
            $data["permiso_inventarios"] = true;
        }else{
            $data["permiso_inventarios"] = false;
        }
        return View('general.equipo', $data);
    }
    
    public function buscar_equipo_general(Request $request){
        $pista = $request["dato"];
        $descripcion_equipo = Descripcion_Equipo::where('cod_scl',$pista)->orWhere('modelo',"like", "%".$pista."%")->first();
        if($descripcion_equipo != null){
            $permiso = Asignacion_Permiso::where("User_email",Auth::user()->email)->where("permiso", "INVENTARIOS")->first();
            if($permiso != null || Auth::user()->actor->jefe_cedula == null){
                $descripcion_equipo->equipos = $descripcion_equipo->equipos()->whereNull("Cliente_identificacion")->get();
            }else{
                $descripcion_equipo->equipos = $descripcion_equipo->equipos()->where("Actor_cedula",Auth::user()->actor->cedula)->whereNull("Cliente_identificacion")->get();
            }
        }
        return $descripcion_equipo;
    }
    
    public function buscar_equipo_especifico(Request $request){
        $pista = $request["dato"];
        $permiso = Asignacion_Permiso::where("User_email",Auth::user()->email)->where("permiso", "INVENTARIOS")->first();
        if($permiso != null || Auth::user()->actor->jefe_cedula == null){
            $equipo = Equipo::where("IMEI",$pista)->first();
        }else{
            $equipo = Equipo::where("IMEI",$pista)->where("Actor_cedula","=",Auth::user()->actor->cedula)->first();
        }
        if($equipo != null){
            $equipo->descripcion_equipo = $equipo->descripcion_equipo;
            $equipo->responsable = $equipo->responsable; 
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
    
    public function eliminar_equipo_especifico(Request $request){
        $IMEI = $request["dato"];
        $equipo = Equipo::find($IMEI);
        if($equipo != null){
            if($equipo->delete()){
                return "EXITOSO";
            }else{
                return "Error al eliminar equipo";
            }
        }else{
            return "Equipo no encontrado";
        }
    }
    
    public function eliminar_equipo_general(Request $request){
        $cod_scl = $request["dato"];
        $equipos = Equipo::where("Descripcion_Equipo_cod_scl",$cod_scl)->get();
        foreach ($equipos as $equipo) {
            $equipo->delete();
        }
        $equipo_general = Descripcion_Equipo::find($cod_scl);
        if($equipo_general != null){
            if($equipo_general->delete()){
                return "EXITOSO";
            }else{
                return "Error al eliminar equipo";
            }
        }else{
            return "Equipo no encontrado";
        }
    }
    
    public function asignar_responsable_equipo(Request $request){
        $datos_equipo = $request['dato'];
        $equipo = Equipo::find($datos_equipo["imei"]);
        if($equipo != ""){
            $hoy = new DateTime();
            $equipo->Actor_cedula = $datos_equipo["responsable"];
            $equipo->fecha_asignacion = $hoy;
            if($equipo->save() == true){
                return "EXITOSO";
            }else{
                return "FALLIDO";
            }
        }else{
            return "FALLIDO";
        }
    }
    
    public function subir_archivo_descripcion(Request $request){
        if ($request->hasFile('archivo_descripcion'))
        {
            $request->file('archivo_descripcion')->move("files/equipo/descripcion"); 
            return \Redirect::route('equipo')->with('subiendo_archivo' ,true);
        }
    }
    
    public function subir_archivo_equipo(Request $request){
        if ($request->hasFile('archivo_equipo'))
        {
            $Actor = Auth::user()->actor;
            $path = $request->file('archivo_equipo');
            $rows = Excel::selectSheetsByIndex(0)->load($path, function($reader) {})->get();
            Queue::push(new EquipoFileUpload($rows,$Actor->cedula));
            return \Redirect::route('equipo')->with('subiendo_archivo' ,true);
        }
    }
}
