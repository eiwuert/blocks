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
}
