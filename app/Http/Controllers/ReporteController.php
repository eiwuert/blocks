<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Equipo;
use DateTime;
use App\Actor;
use App\Notificacion;
use App\Simcard;

class ReporteController extends Controller
{
    public function reportes_inventario(Request $request)
    {
        $data = array();
        $Actor = Auth::user()->actor;
        $data['Actor'] = $Actor;
        // CARGAR NOTIFICACIONES
        $data['notificaciones'] = Notificacion::where("Actor_cedula",$Actor->cedula)->where("descripcion","<>","")->get();
        // OBTENER INFORMACIÓN ASIGNACIONES
        $actores = Actor::all();
        foreach ($actores as $actor) {
            $actor->cantidad_prepago = Simcard::whereHas('paquete',function ($query) use ($actor){
                                    $query->where("Actor_cedula","=", $actor->cedula);
                                })->whereNull("Cliente_identificacion")->where("categoria",'=','Prepago')->count();
            $actor->cantidad_libre = Simcard::whereHas('paquete',function ($query) use ($actor){
                                    $query->where("Actor_cedula","=", $actor->cedula);
                                })->whereNull("Cliente_identificacion")->where("categoria",'=','Libre')->count();
            $actor->cantidad_postpago = Simcard::whereHas('paquete',function ($query) use ($actor){
                                    $query->where("Actor_cedula","=", $actor->cedula);
                                })->whereNull("Cliente_identificacion")->where("categoria",'=','Postpago')->count();
            $actor->cantidad_equipo =  Equipo::where("Actor_cedula","=",$actor->cedula)->whereNull("Cliente_identificacion")->count();
        }
        $data["actores"] = $actores;
        return View('admin.reportes_inventario', $data);
    }
}
