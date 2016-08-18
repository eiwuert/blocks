<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\Actor;
use App\Notificacion;
use App\Asignacion_Permiso;
use App\Http\Controllers\Controller;

class SeguridadController extends Controller
{
    public function permisos(Request $request){
        $data = array();
        $Actor = Auth::user()->actor;
        $data['Actor'] = $Actor;
        // CARGAR NOTIFICACIONES
        $data['notificaciones'] = Notificacion::where("Actor_cedula",$Actor->cedula)->get();
        // OBTENER POSIBLES RESPONSABLES
        $actores = Actor::has("user")->whereNotNull("jefe_cedula")->get();
        foreach ($actores as $actor) {
            $actor->user = $actor->user;
            $aux = [];
            foreach ($actor->user->permisos as $permiso){
                array_push($aux, $permiso->permiso);
            }
            $actor->permisos = $aux;
        }
        $data["actores"] = $actores;
        return View('admin.permisos', $data);
    }
    
    public function guardar_permisos(Request $request){
        try{
            $data = $request["data"];
            Asignacion_Permiso::truncate();
            if($data != null){
                if(array_key_exists("INVENTARIOS", $data)){
                    $inventarios = $data["INVENTARIOS"];
                    foreach ($inventarios as $permiso) {
                        $asignacion_permiso = new Asignacion_Permiso();
                        $asignacion_permiso->User_email = $permiso;
                        $asignacion_permiso->permiso = "INVENTARIOS";
                        $asignacion_permiso->save();
                    }            
                }
                if(array_key_exists("ARCHIVOS", $data)){
                    $archivos = $data["ARCHIVOS"];
                    foreach ($archivos as $permiso) {
                        $asignacion_permiso = new Asignacion_Permiso();
                        $asignacion_permiso->User_email = $permiso;
                        $asignacion_permiso->permiso = "ARCHIVOS";
                        $asignacion_permiso->save();
                    }            
                }
            }
            return "EXITOSO";
        }catch(Exception $e){
            return $e->getMessage;
        }
    }
}
