<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Actor;
use App\Comision;
use App\Simcard;
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

    public function buscar_comision(Request $request){
        $periodo = $request['periodo'];
        $Actor = $request['actor'];
        $data = [];
        if($Actor == null){
            $Actor = Auth::user()->actor;
        }else{
            $Actor = Actor::where("nombre", $Actor)->first();
        }
        if($Actor != null){
            
            $data["simcards_prepago"] = Comision::whereHas('simcard' , function ($query){
                                    $query->where('categoria', 'Prepago');
                                })
                                ->whereHas('simcard.paquete' , function ($query) use ($Actor)  {
                                    $query->where("Actor_cedula","=", $Actor->cedula);
                                })
                                ->where(DB::raw('extract(year_month FROM fecha)'),$periodo)
                                ->whereNotNull("Simcard_ICC")->sum("valor")*$Actor->porcentaje_prepago;
            
            $data["simcards_libre"] = Comision::whereHas('simcard' , function ($query){
                                    $query->where('categoria', 'Libre');
                                })
                                ->whereHas('simcard.paquete' , function ($query) use ($Actor)  {
                                    $query->where("Actor_cedula","=", $Actor->cedula);
                                })
                                ->where(DB::raw('extract(year_month FROM fecha)'),$periodo)
                                ->whereNotNull("Simcard_ICC")->sum("valor")*$Actor->porcentaje_libre;
            // Calcular postpagos
            $aux = substr($periodo,0,4) . "-" . substr($periodo,4,2) . "-1";
            $periodo_aux = date('Ym', strtotime("-1 months", strtotime($aux)));
            $data["simcards_postpago"] = \DB::table('Simcard')
            ->join("Asignacion_Plan", "Asignacion_Plan.Simcard_ICC","=","Simcard.ICC")
            ->join("Plan","Plan.codigo","=","Asignacion_Plan.Plan_codigo")
            ->join("Paquete", "Simcard.Paquete_ID","=","Paquete.ID")
            ->where("Paquete.Actor_cedula","=",$Actor->cedula)
            ->where(DB::raw('extract(year_month FROM fecha_venta)'),"=",$periodo_aux)
            ->where("Simcard.primer_pago","=",true)
            ->sum("Plan.valor");
            
            $periodo_aux = date('Ym', strtotime("-2 months", strtotime($aux)));
            $data["simcards_postpago"] += \DB::table('Simcard')
            ->join("Asignacion_Plan", "Asignacion_Plan.Simcard_ICC","=","Simcard.ICC")
            ->join("Plan","Plan.codigo","=","Asignacion_Plan.Plan_codigo")
            ->join("Paquete", "Simcard.Paquete_ID","=","Paquete.ID")
            ->where("Paquete.Actor_cedula","=",$Actor->cedula)
            ->where(DB::raw('extract(year_month FROM fecha_venta)'),"=",$periodo_aux)
            ->where("Simcard.segundo_pago","=",true)
            ->sum("Plan.valor");
            
            $periodo_aux = date('Ym', strtotime("-3 months", strtotime($aux)));
            $data["simcards_postpago"] += \DB::table('Simcard')
            ->join("Asignacion_Plan", "Asignacion_Plan.Simcard_ICC","=","Simcard.ICC")
            ->join("Plan","Plan.codigo","=","Asignacion_Plan.Plan_codigo")
            ->join("Paquete", "Simcard.Paquete_ID","=","Paquete.ID")
            ->where("Paquete.Actor_cedula","=",$Actor->cedula)
            ->where(DB::raw('extract(year_month FROM fecha_venta)'),"=",$periodo_aux)
            ->where("Simcard.tercer_pago","=",true)
            ->sum("Plan.valor");
            
            $periodo_aux = date('Ym', strtotime("-6 months", strtotime($aux)));
            $data["simcards_postpago"] += \DB::table('Simcard')
            ->join("Asignacion_Plan", "Asignacion_Plan.Simcard_ICC","=","Simcard.ICC")
            ->join("Plan","Plan.codigo","=","Asignacion_Plan.Plan_codigo")
            ->join("Paquete", "Simcard.Paquete_ID","=","Paquete.ID")
            ->where("Paquete.Actor_cedula","=",$Actor->cedula)
            ->where(DB::raw('extract(year_month FROM fecha_venta)'),"=",$periodo_aux)
            ->where("Simcard.cuarto_pago","=",true)
            ->sum("Plan.valor");
            
            $data["servicios"] = Comision::where(DB::raw('extract(year_month FROM fecha)'),$periodo)->whereNotNull("Servicio_peticion")->sum("valor")*$Actor->porcentaje_servicio;
        }
        return $data;
    }
    
    public function detalle_comision_prepago(Request $request){
        
        $Actor = $request['actor'];
        $periodo = $request['periodo'];
        if($Actor == null){
            $Actor = Auth::user()->actor;
        }else{
            $Actor = Actor::where("nombre", $Actor)->first();
        }
        if($Actor != null){
            $data["simcards"] = Comision::whereHas('simcard.paquete', function ($query)  use ($Actor){
                $query->where('categoria', 'Prepago')->where("Actor_cedula","=", $Actor->cedula);
            })->where(DB::raw('extract(year_month FROM fecha)'),$periodo)->whereNotNull("Simcard_ICC")->get();
            $data["porcentaje"] = $Actor->porcentaje_prepago;
        }
        return $data;
    }
    
    public function detalle_comision_libre(Request $request){
        $Actor = $request['actor'];
        $periodo = $request['periodo'];
        if($Actor == null){
            $Actor = Auth::user()->actor;
        }else{
            $Actor = Actor::where("nombre", $Actor)->first();
        }
        if($Actor != null){
            $data["simcards"] = Comision::whereHas('simcard.paquete', function ($query)  use ($Actor){
                $query->where('categoria', 'Libre')->where("Actor_cedula","=", $Actor->cedula);
            })->where(DB::raw('extract(year_month FROM fecha)'),$periodo)->whereNotNull("Simcard_ICC")->get();
            $data["porcentaje"] = $Actor->porcentaje_libre;
        }
        return $data;
    }
    
    public function detalle_comision_postpago(Request $request){
        $Actor = $request['actor'];
        $periodo = $request['periodo'];
        if($Actor == null){
            $Actor = Auth::user()->actor;
        }else{
            $Actor = Actor::where("nombre", $Actor)->first();
        }
        if($Actor != null){
            $aux = substr($periodo,0,4) . "-" . substr($periodo,4,2). "-1";
            $data["simcards_postpago_primera"] = Comision::whereHas('simcard' , function ($query) use ($aux){
                                    $query->where('categoria', 'Postpago')
                                    ->where(DB::raw('extract(year_month FROM fecha_venta)'),  
                                    date('Ym', strtotime("-1 months", strtotime($aux))));
                                })
                                ->whereHas('simcard.paquete' , function ($query) use ($Actor)  {
                                    $query->where("Actor_cedula","=", $Actor->cedula);
                                })
                                ->where(DB::raw('extract(year_month FROM fecha)'), $periodo)
                                ->whereNotNull("Simcard_ICC")->sum("valor")*0.5*$Actor->porcentaje_postpago/$Actor->cantidad_cuotas;
            $data["simcards_postpago_segunda"] = Comision::whereHas('simcard' , function ($query) use ($aux){
                                    $query->where('categoria', 'Postpago')
                                    ->where(DB::raw('extract(year_month FROM fecha_venta)'),  
                                    date('Ym', strtotime("-2 months", strtotime($aux))));
                                })
                                ->whereHas('simcard.paquete' , function ($query) use ($Actor)  {
                                    $query->where("Actor_cedula","=", $Actor->cedula);
                                })
                                ->where(DB::raw('extract(year_month FROM fecha)'), $periodo)
                                ->whereNotNull("Simcard_ICC")->get();
            $data["simcards_postpago_tercera"] = Comision::whereHas('simcard' , function ($query) use ($aux){
                                    $query->where('categoria', 'Postpago')
                                    ->where(DB::raw('extract(year_month FROM fecha_venta)'),  
                                    date('Ym', strtotime("-3 months", strtotime($aux))));
                                })
                                ->whereHas('simcard.paquete' , function ($query) use ($Actor)  {
                                    $query->where("Actor_cedula","=", $Actor->cedula);
                                })
                                ->where(DB::raw('extract(year_month FROM fecha)'), $periodo)
                                ->whereNotNull("Simcard_ICC")->get();
            $data["simcards_postpago_sexta"] = Comision::whereHas('simcard' , function ($query) use ($aux){
                                    $query->where('categoria', 'Postpago')
                                    ->where(DB::raw('extract(year_month FROM fecha_venta)'),  
                                    date('Ym', strtotime("-6 months", strtotime($aux))));
                                })
                                ->whereHas('simcard.paquete' , function ($query) use ($Actor)  {
                                    $query->where("Actor_cedula","=", $Actor->cedula);
                                })
                                ->where(DB::raw('extract(year_month FROM fecha)'), $periodo)
                                ->whereNotNull("Simcard_ICC")->get();
            $data["porcentaje"] = $Actor->porcentaje_postpago/$Actor->cantidad_cuotas;
        }
        return $data;
    }
    
    public function subir_archivo(Request $request){
        if ($request->hasFile('archivo_comision'))
        {
            $Actor = Auth::user()->actor;
            $path = $request->file('archivo_comision');
            $rows = Excel::selectSheetsByIndex(0)->load($path, function($reader) {})->get();
            Queue::push(new ComisionFileUpload($rows,$Actor->cedula));
            return \Redirect::route('comision')->with('subiendo_archivo' ,true);
        }
    }
}
