<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Actor;
use App\Paquete;
use Datetime;
use DB;
use App\Simcard;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SimcardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $Actor = Actor::find(Auth::user()->Actor_cedula);
        $Actor_nombre = $Actor->nombre;
        $data['Actor_nombre'] = $Actor_nombre;
        $data['Cantidad_notificaciones'] = 0;
        
        // CONTAR LAS SIMCARDS PREPAGO
        $data['Total_prepago'] = Simcard::whereHas('paquete', function ($query) {
            $query->where('Actor_cedula', '=', Auth::user()->Actor_cedula);
        })->where("categoria",'=','Prepago')->whereNull('fecha_activacion')->where(DB::raw("DATEDIFF(CURRENT_DATE,fecha_vencimiento)"), '>', 0)->count();
        
        $data['Total_prepago_activas'] = Simcard::whereHas('paquete', function ($query) {
            $query->where('Actor_cedula', '=', Auth::user()->Actor_cedula);
        })->where("categoria",'=','Prepago')->where(DB::raw("ROUND(DATEDIFF(CURRENT_DATE,fecha_activacion)/30)"), '<', 6)->count();
        
        $data['Total_prepago_vencidas'] = Simcard::whereHas('paquete', function ($query) {
            $query->where('Actor_cedula', '=', Auth::user()->Actor_cedula);
        })->where("categoria",'=','Prepago')->where(function ($query) {
                $query->where(DB::raw("ROUND(DATEDIFF(CURRENT_DATE,fecha_activacion)/30)"), '>=', 6)
                      ->orWhere(DB::raw("DATEDIFF(CURRENT_DATE,fecha_vencimiento)"), '<=', 0);
            })->count();
        
        // CONTAR LAS SIMCARDS LIBRE
        $data['Total_libres'] = Simcard::whereHas('paquete', function ($query) {
            $query->where('Actor_cedula', '=', Auth::user()->Actor_cedula);
        })->where("categoria",'=','Libre')->whereNull('fecha_activacion')->where(DB::raw("DATEDIFF(CURRENT_DATE,fecha_vencimiento)"), '>', 0)->count();
        
        $data['Total_libres_activas'] = Simcard::whereHas('paquete', function ($query) {
            $query->where('Actor_cedula', '=', Auth::user()->Actor_cedula);
        })->where("categoria",'=','Libre')->where(DB::raw("ROUND(DATEDIFF(CURRENT_DATE,fecha_activacion)/30)"), '<', 6)->count();
        
        $data['Total_libres_vencidas'] = Simcard::whereHas('paquete', function ($query) {
            $query->where('Actor_cedula', '=', Auth::user()->Actor_cedula);
        })->where("categoria",'=','Libre')->where(function ($query) {
                $query->where(DB::raw("ROUND(DATEDIFF(CURRENT_DATE,fecha_activacion)/30)"), '>=', 6)
                      ->orWhere(DB::raw("DATEDIFF(CURRENT_DATE,fecha_vencimiento)"), '<=', 0);
            })->count();
        
        // CONTAR LAS SIMCARDS POSTPAGO
        $data['Total_postpago'] = Simcard::where("categoria",'=','Postago')->count();
        
        // OBTENER LOS POSIBLES RESPONSABLES
        
        return View('simcard', $data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    
    public function buscar_simcard(Request $request)
    {
        $pista = $request['dato'];
        $simcard = Simcard::where("ICC",'=',$pista)->orWhere("numero_linea","=",$pista)->first();
        if($simcard != ""){
            //OBTENER EL RESPONSABLE DE LA SIMCARD
            $Cedula_responsable = Paquete::find($simcard->Paquete_ID)->first()->Actor_cedula;
            $responsable = Actor::find($Cedula_responsable)->first()->nombre;
            $simcard["responsable_simcard"] = $responsable;
            $hoy = new DateTime();
            $fecha_vencimiento = new DateTime($simcard->fecha_vencimiento);
            if($simcard->fecha_activacion != null){
                $fecha_activacion = new DateTime($simcard->fecha_activacion);    
                $interval = $hoy->diff($fecha_vencimiento);
                $meses = $interval->format("%y")*12+$interval->format("%m");
                if($meses > 6){
                    $simcard["color"] = "rojo";
                }else{
                    $simcard["color"] = "verde";
                }
            }else{
                $interval = $hoy->diff($fecha_vencimiento);
                $dias = $interval->format("%d");
                if($dias < 0){
                    $simcard["color"] = "rojo";
                }else{
                    $simcard["color"] = "azul";
                }
            }
        }
        return $simcard;
    }

    public function actualizar_simcard(Request $request)
    {
        $datos_simcard = $request['dato'];
        $simcard = Simcard::find($datos_simcard["ICC"]);
        if($simcard != ""){
            $simcard->numero_linea = $datos_simcard["Simcard_numero_linea"];
            $simcard->fecha_adjudicacion = $datos_simcard["Simcard_fecha_adjudicacion"];
            $simcard->fecha_activacion = $datos_simcard["Simcard_fecha_activacion"];
            $simcard->fecha_vencimiento = $datos_simcard["Simcard_fecha_vencimiento"];
            $simcard->save();
            return "EXITOSO";
        }else{
            return "FALLIDO";
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
