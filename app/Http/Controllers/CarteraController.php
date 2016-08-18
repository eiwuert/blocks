<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Actor;
use App\Notificacion;
use App\Registro_Cartera;

class CarteraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $nombre = $request["nombre"];
        $data = array();
        $Actor = Auth::user()->actor;
        $data['Actor'] = $Actor;
        // CARGAR NOTIFICACIONES
        $data['notificaciones'] = Notificacion::where("Actor_cedula",$Actor->cedula)->whereNotNull("descripcion")->get();
        $data["nombre"] = $nombre;
        if($Actor->jefe != null){
            return View('employee.cartera', $data);
        }else{
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
            return View('admin.cartera', $data);
        }
    }

    public function buscar_cartera(Request $request){
        $nombre = $request["nombre"];
        $actor = Actor::where("nombre",$nombre)->first();
        if($actor != null){
            $cedula = $actor->cedula;
            $registros = Registro_Cartera::where("Actor_cedula",$cedula)->orderBy('fecha', 'asc')->get();
        }
        return $registros;
    }
    public function obtener_registro(Request $request){
        $registro = Registro_Cartera::find($request["ID"]);
        return $registro;
    }
    
    public function actualizar_registro(Request $request){
        $datos_registro = $request["datos_registro"];
        $ID = $datos_registro["ID"];
        $registro = Registro_Cartera::find($ID);
        if($registro != null){
            $registro->fecha = $datos_registro["Registro_fecha"];
            $registro->descripcion = $datos_registro["Registro_descripcion"];
            $registro->valor_unitario = $datos_registro["Registro_valor_unitario"];
            $registro->cantidad = $datos_registro["Registro_cantidad"];
            if($registro->save()){
                return "EXITOSO";
            }else{
                return "ERROR";
            }
        }else{
            return "No se encontró el registro";
        }
    }
    
    public function crear_registro(Request $request){
        $datos_registro = $request["datos_registro"];
        $nombre = $datos_registro["Actor_nombre"];
        $actor = Actor::where("nombre",$nombre)->first();
        if($actor != null){
            $registro = new Registro_Cartera();
            if($registro != null){
                $registro->Actor_cedula = $actor->cedula;
                $registro->fecha = $datos_registro["Registro_fecha"];
                $registro->descripcion = $datos_registro["Registro_descripcion"];
                $registro->valor_unitario = $datos_registro["Registro_valor_unitario"];
                $registro->cantidad = $datos_registro["Registro_cantidad"];
                if($registro->save()){
                    return "EXITOSO";
                }else{
                    return "ERROR";
                }
            }else{
                return "No se encontró el registro";
            }
        }else{
            return "Actor no encontrado";
        }
    }
    
    public function eliminar_registro(Request $request){
        $ID = $request["ID"];
        $registro = Registro_Cartera::find($ID);
        if($registro != null){
            if($registro->delete()){
                return "EXITOSO";
            }else{
                return "ERROR";
            }
        }else{
            return "No se encontró el registro";
        }
    }
}
