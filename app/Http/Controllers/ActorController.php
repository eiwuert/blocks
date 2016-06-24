<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Actor;
use Auth;
use App\Ubicacion;
class ActorController extends Controller
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
        $data['Actor'] = Auth::user()->actor;
        $data['Cantidad_notificaciones'] = 0;
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
        return View('personal',$data);
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
}
