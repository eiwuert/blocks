<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use DateTime;
use App\Actor;
use Excel;
use Queue;
use App\Asignacion_Permiso;
use App\Notificacion;
use App\Http\Controllers\Controller;

class FijaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $peticion = $request["peticion"];
        $data = array();
        $Actor = Auth::user()->actor;
        $data['Actor'] = $Actor;
        $data['peticion'] = $peticion;
        // CARGAR NOTIFICACIONES
        $data['notificaciones'] = Notificacion::where("Actor_cedula",$Actor->cedula)->where("descripcion","<>","")->get();
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
        return View('general.fija', $data);
    }

}
