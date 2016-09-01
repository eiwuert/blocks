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
use App\Fija;

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
        $permisos = $Actor->user->permisos;
        $lista_permisos = [];
        foreach ($permisos as $permiso) {
            array_push($lista_permisos,$permiso->permiso);
        }
        $Actor->lista_permisos = $lista_permisos;
        return View('general.fija', $data);
    }

    public function buscar_fija(Request $request)
    {
        $pista = $request["dato"];
        $Actor = Auth::user()->actor;
        $permiso = Asignacion_Permiso::where("User_email",Auth::user()->email)->where("permiso", "INVENTARIOS")->first();
        if($permiso != null || Auth::user()->actor->jefe_cedula == null){
            $fija = Fija::Where('peticion',"like", "%".$pista."%")->first();
        }else{
            $fija = Fija::Where('peticion',"like", "%".$pista."%")->where("Actor_cedula",$Actor->cedula)->first();    
        }
        return $fija;
    }
    
    public function subir_archivo(Request $request){
        if ($request->hasFile('archivo_fija'))
        {
            $Actor = Auth::user()->actor;
            $path = $request->file('archivo_fija');
            $rows = Excel::selectSheetsByIndex(0)->load($path, function($reader) {})->get();
            Queue::push(new FijaFileUpload($rows,$Actor->cedula));
            return \Redirect::route('fija')->with('subiendo_archivo' ,true);
        }
    }
}
