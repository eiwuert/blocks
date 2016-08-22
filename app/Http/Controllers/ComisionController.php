<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Actor;
use App\Comision;
use App\Notificacion;
use Auth;
use DB;
use DateTime;
use Excel;
use Queue;
use App\Jobs\ComisionFileUpload;

class ComisionController extends Controller
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
        $data['Actor'] = $Actor;
        // CARGAR NOTIFICACIONES
        $data['notificaciones'] = Notificacion::where("Actor_cedula",$Actor->cedula)->where("descripcion","<>","")->get();
        $data['periodos'] = DB::table('Comision')->select(DB::raw('extract(year_month FROM fecha) as periodo'))->distinct()->orderBy('fecha','desc')->get();
        if($Actor->jefe != null){
           
        }else{
             $data['actores'] = Actor::all();
        }
        return View('general.comision',$data);
    }

//TODO REVISAR QUE SEA DEL ACTOR
    public function buscar_comision(Request $request){
        $datos = $request["data"];
        $periodo = $datos['periodo'];
        $Actor = $datos['actor'];
        if($Actor == null){
            $Actor = Auth::user()->actor;
        }
        $data["simcards_prepago"] = Comision::whereHas('simcard.paquete', function ($query) use ($Actor)  {
            $query->where('categoria', 'Prepago')->where("Actor_cedula","=", $Actor->cedula);
        })->where(DB::raw('extract(year_month FROM fecha)'),$periodo)->whereNotNull("Simcard_ICC")->sum("valor")*$Actor->porcentaje_prepago;
        $data["simcards_libre"] = Comision::whereHas('simcard.paquete',function ($query)  use ($Actor){
            $query->where('categoria', 'Libre')->where("Actor_cedula","=", $Actor->cedula);
        })->where(DB::raw('extract(year_month FROM fecha)'),$periodo)->whereNotNull("Simcard_ICC")->sum("valor")*$Actor->porcentaje_libre;
        $data["simcards_postpago"] = Comision::whereHas('simcard.paquete', function ($query)  use ($Actor){
            $query->where('categoria', 'Postpago')->where("Actor_cedula","=", $Actor->cedula);
        })->where(DB::raw('extract(year_month FROM fecha)'),$periodo)->whereNotNull("Simcard_ICC")->sum("valor")*$Actor->porcentaje_postpago;
        $data["equipos"] = Comision::where(DB::raw('extract(year_month FROM fecha)'),$periodo)->whereNotNull("Equipo_IMEI")->sum("valor")*$Actor->porcentaje_equipo;
        $data["servicios"] = Comision::where(DB::raw('extract(year_month FROM fecha)'),$periodo)->whereNotNull("Servicio_peticion")->sum("valor")*$Actor->porcentaje_servicio;
        return $data;
    }
    
    public function detalle_comision_prepago(Request $request){
        
        $datos = $request["datos"];
        $periodo = $datos['periodo'];
        $Actor = $datos['actor'];
        if($Actor == null){
            $Actor = Auth::user()->actor;
        }
        $data["simcards"] = Comision::whereHas('simcard.paquete', function ($query)  use ($Actor){
            $query->where('categoria', 'Prepago')->where("Actor_cedula","=", $Actor->cedula);
        })->where(DB::raw('extract(year_month FROM fecha)'),$periodo)->whereNotNull("Simcard_ICC")->get();
        $data["porcentaje"] = $Actor->porcentaje_prepago;
        return $data;
    }
    
    public function detalle_comision_libre(Request $request){
        $datos = $request["datos"];
        $periodo = $datos['periodo'];
        $Actor = $datos['actor'];
        if($Actor == null){
            $Actor = Auth::user()->actor;
        }
        $data["simcards"] = Comision::whereHas('simcard.paquete', function ($query)  use ($Actor){
            $query->where('categoria', 'Libre')->where("Actor_cedula","=", $Actor->cedula);
        })->where(DB::raw('extract(year_month FROM fecha)'),$periodo)->whereNotNull("Simcard_ICC")->get();
        $data["porcentaje"] = $Actor->porcentaje_libre;
        return $data;
    }
    
    public function detalle_comision_postpago(Request $request){
        $datos = $request["datos"];
        $periodo = $datos['periodo'];
        $Actor = $datos['actor'];
        if($Actor == null){
            $Actor = Auth::user()->actor;
        }
        $data["simcards"] = Comision::whereHas('simcard.paquete', function ($query)  use ($Actor){
            $query->where('categoria', 'Postpago')->where("Actor_cedula","=", $Actor->cedula);
        })->where(DB::raw('extract(year_month FROM fecha)'),$periodo)->whereNotNull("Simcard_ICC")->get();
        $data["porcentaje"] = $Actor->porcentaje_postpago;
        return $data;
    }
    
    public function subir_archivo(Request $request){
        if ($request->hasFile('archivo_comision'))
        {
            $Actor = Auth::user()->actor;
            $path = $request->file('archivo_comision');
            $rows = Excel::selectSheetsByIndex(0)->load($path, function($reader) {})->get();
            Queue::push(new ComisionFileUpload($rows,$Actor->cedula));
            return \Redirect::route('general.comision')->with('subiendo_archivo' ,true);
        }
    }
}
