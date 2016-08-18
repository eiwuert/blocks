<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Actor;
use App\Notificacion;
use App\Error;
use App\Ubicacion_Empleado;
use Auth;
use DateTime;
use App\Ubicacion;
class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cedula_buscada = $request["cedula"];
        $data = array();
        $Actor = Auth::user()->actor;
        $data['Actor'] = Auth::user()->actor;
        // CARGAR NOTIFICACIONES
        $data['notificaciones'] = Notificacion::where("Actor_cedula",$Actor->cedula)->where("descripcion","<>","")->get();
        $regiones = Ubicacion::select('region')->distinct()->get();
        foreach ($regiones as &$region) {
            $region->ciudades = Ubicacion::select('ciudad')->where('region',$region->region)->get();
        }
        $data["regiones"] = $regiones;
        // OBTENER LOS POSIBLES EMPLEADOS
        $actores_sin_revisar = [$Actor];
        $actores = array();
        while(count($actores_sin_revisar) > 0){
            $actor = array_pop($actores_sin_revisar);
            if(!empty($actor)){
                $cedula = $actor["cedula"];
                array_push($actores,$actor);
                $empleados = Actor::where("jefe_cedula", '=', $cedula)->get()->toArray();
                foreach ($empleados as $empleado) {
                    array_push($actores_sin_revisar, $empleado);
                }
            }
        }
        $data['actores'] = $actores;
        $data["cedula"] = $cedula_buscada;        
        return View('general.personal',$data);
    }

    public function control_vendedores(Request $request){
        $data = array();
        $Actor = Auth::user()->actor;
        $data['Actor'] = Auth::user()->actor;
        $data['Cantidad_notificaciones'] = 0;
        // CARGAR NOTIFICACIONES
        $data['notificaciones'] = [];
        // OBTENER LOS POSIBLES EMPLEADOS
        $actores_sin_revisar = [$Actor];
        $actores = array();
        while(count($actores_sin_revisar) > 0){
            $actor = array_pop($actores_sin_revisar);
            if(!empty($actor)){
                $cedula = $actor["cedula"];
                array_push($actores,$actor);
                $empleados = Actor::where("jefe_cedula", '=', $cedula)->get()->toArray();
                foreach ($empleados as $empleado) {
                    array_push($actores_sin_revisar, $empleado);
                }
            }
        }
        $data['actores'] = $actores; 
        return View('general.control_vendedores',$data);    
    }
    
    public function control_vendedores_front(Request $request){
        return View('general.control_vendedores_front');    
    }
    
    public function buscar_actor(Request $request){
        $pista = $request["dato"];
        $actor = Actor::where('cedula','like','%' . $pista . '%')->orWhere('nombre', 'like' , '%' . $pista . '%')->first();
        if($actor != null){
            if($actor->cedula != Auth::user()->actor->cedula){
                // REVISAR AUTORIZACION
                $usuario = Auth::user()->actor;
                $jefe = $actor->jefe;
                $autorizado = false;
                while($jefe != null && $autorizado == false){
                    if($jefe->cedula == $usuario->cedula){
                        $autorizado = true;
                    }
                    $jefe = $jefe->jefe;
                }
                if($autorizado == false){
                    return 'NO AUTORIZADO';
                }
            }
            // HALLAR JEFE
            if($actor->jefe != null){
                $actor->jefe = $actor->jefe;
            }
            $actor->ubicacion = $actor->ubicacion;
        }
        return $actor;
    }
    
    public function crear_actor(Request $request){
        $datos_actor = $request["dato"];
        $actor = Actor::find($datos_actor["Actor_cedula"]);
        if($actor != null){
            return "La cedula ya se encuentra registrada";
        }
        $actor = new Actor();
        $actor->cedula = $datos_actor["Actor_cedula"];
        $actor->nombre = $datos_actor["Actor_nombre"];
        $actor->jefe_cedula = $datos_actor["Actor_jefe_cedula"];
        $ubicacion = Ubicacion::where("region",$datos_actor["Actor_region"])->where("ciudad",$datos_actor["Actor_ciudad"])->first();
        if($ubicacion != null){
            $actor->Ubicacion_ID = $ubicacion->ID;
        }else{
            return "Problema asignando la ubicación";
        }
        $actor->telefono = $datos_actor["Actor_telefono"];
        $actor->correo = $datos_actor["Actor_correo"];
        $actor->sueldo = $datos_actor["Actor_sueldo"];
        $actor->porcentaje_prepago = $datos_actor["Actor_porcentaje_prepago"];
        $actor->porcentaje_libre = $datos_actor["Actor_porcentaje_libre"];
        $actor->porcentaje_postpago = $datos_actor["Actor_porcentaje_postpago"];
        $actor->porcentaje_equipo = $datos_actor["Actor_porcentaje_equipo"];
        $actor->porcentaje_servicio = $datos_actor["Actor_porcentaje_servicio"];
        if($actor->save()){
            return "EXITOSO";
        }else{
            return "Error guardando el empleado";
        }
    }
    
    public function actualizar_actor(Request $request){
        $datos_actor = $request["dato"];
        if($datos_actor["Actor_cedula_copia"] != $datos_actor["Actor_cedula"]){
            $actor_aux = Actor::find($datos_actor["Actor_cedula"]);
            if($actor_aux != null){
                return "La cedula ya se encuentra registrada";
            }else{
                $actor = new Actor();
                $actor->cedula = $datos_actor["Actor_cedula"];
            }    
        }else{
            $actor = Actor::find($datos_actor["Actor_cedula"]);
        }
        $actor->nombre = $datos_actor["Actor_nombre"];
        if($datos_actor["Actor_jefe_cedula"]!= null)
            $actor->jefe_cedula = $datos_actor["Actor_jefe_cedula"];
        $ubicacion = Ubicacion::where("region",$datos_actor["Actor_region"])->where("ciudad",$datos_actor["Actor_ciudad"])->first();
        if($ubicacion != null){
            $actor->Ubicacion_ID = $ubicacion->ID;
        }else{
            return "Problema asignando la ubicación";
        }
        $actor->telefono = $datos_actor["Actor_telefono"];
        $actor->correo = $datos_actor["Actor_correo"];
        $actor->sueldo = $datos_actor["Actor_sueldo"];
        $actor->porcentaje_prepago = $datos_actor["Actor_porcentaje_prepago"];
        $actor->porcentaje_libre = $datos_actor["Actor_porcentaje_libre"];
        $actor->porcentaje_postpago = $datos_actor["Actor_porcentaje_postpago"];
        $actor->porcentaje_equipo = $datos_actor["Actor_porcentaje_equipo"];
        $actor->porcentaje_servicio = $datos_actor["Actor_porcentaje_servicio"];
        if($actor->save()){
            if($datos_actor["Actor_cedula_copia"] != $datos_actor["Actor_cedula"]){
                $actor_aux = Actor::find($datos_actor["Actor_cedula_copia"]);
                $user = $actor_aux->user;
                if($user != null){
                    $user->Actor_cedula = $datos_actor["Actor_cedula"];
                    $user->save();
                }
                $empleados = Actor::where("jefe_cedula", $actor_aux->cedula)->get();
                foreach ($empleados as $empleado) {
                    $empleado->jefe_cedula = $datos_actor["Actor_cedula"];
                    $empleado->save();
                }
                $paquetes = $actor_aux->paquetes;
                foreach ($paquetes as $paquete) {
                    $paquete->Actor_cedula = $datos_actor["Actor_cedula"];
                    $paquete->save();
                }
                $equipos = $actor_aux->equipos;
                foreach ($equipos as $equipo) {
                    $equipo->Actor_cedula = $datos_actor["Actor_cedula"];
                    $equipo->save();
                }
                $registros_cartera = $actor_aux->registros_cartera;
                foreach ($registros_cartera as $registro) {
                    $registro->Actor_cedula = $datos_actor["Actor_cedula"];
                    $registro->save();
                }
                $actor_aux->delete();
            }
            return "EXITOSO";
        }else{
            return "Error guardando el empleado";
        }
    }
    
    public function eliminar_actor(Request $request){
        $cedula = $request["dato"];
        $actor = Actor::find($cedula);
        if($actor != null){
            $empleados = Actor::where("jefe_cedula", $cedula)->get();
            $user = $actor->user;
            if($user != null){
                $user->delete();
            }
            foreach ($empleados as $empleado) {
                $empleado->jefe_cedula = Auth::user()->actor->cedula;
                $empleado->save();
            }
            $paquetes = $actor->paquetes;
            foreach ($paquetes as $paquete) {
                $paquete->Actor_cedula = null;
                $paquete->save();
            }
            $equipos = $actor->equipos;
            foreach ($equipos as $equipo) {
                $equipo->Actor_cedula = null;
                $equipo->save();
            }
            $registros_cartera = $actor->registros_cartera;
            foreach ($registros_cartera as $registro) {
                $registro->delete();
            }
            $actor->delete();
            return "EXITOSO";
        }else{
            return "No se encuentra registrada la cedula";
        }
    }
    
    
    public function buscar_ubicaciones(Request $request){
        $nombre = $request["nombre"];
        $actor = Actor::where("nombre",$nombre)->first();
        if($actor != null){
            $cedula = $actor->cedula;
            $ubicaciones = Ubicacion_Empleado::where("Actor_cedula",$cedula)->get();
        }
        return $ubicaciones;
    }
    
    public function guardar_ubicacion(Request $request){
        $hoy = new DateTime();
        $ubicacion = new Ubicacion_Empleado();
        $ubicacion->fecha = $hoy;
        $ubicacion->Actor_cedula = $request["cedula"];
        $ubicacion->latitud = $request["latitud"];
        $ubicacion->longitud = $request["longitud"];
        if($ubicacion->save()){
            return "EXITOSO";
        }else{
            return "ERROR";
        }
    }
    
    public function eliminar_notificacion(Request $request){
        $id = $request["id"];
        $notificacion = Notificacion::find($id);
        if($notificacion != null){
            $notificacion->delete();
            return "EXITOSO";
        }else{
            return "No se encuentra registrada la cedula";
        }
    }
    
    public function ver_notificacion(Request $request){
        $id = $request["id"];
        $notificacion = Notificacion::find($id);
        $Actor = Auth::user()->actor;
        $data['notificacion'] = $notificacion;
        $data['errores'] = Error::where("Notificacion_ID", $notificacion->ID)->get();
        $data['Actor'] = Auth::user()->actor;
        // CARGAR NOTIFICACIONES
        $data['notificaciones'] = Notificacion::where("Actor_cedula",$Actor->cedula)->get();
        return View('general.notificacion',$data);    
    }
}
