<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Actor;
use App\Plan;
use App\Paquete;
use Datetime;
use App\Asignacion_Plan;
use DB;
use Log;
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
        // OBTENER LOS POSIBLES RESPONSABLES
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
        $data['responsables'] = $actores;
        
        // OBTENER LOS POSIBLES PLANES
        $planes = Plan::all();
        $data['planes'] = $planes;
        return View('simcard', $data);
    }

    
    public function asignar_responsable_paquete(Request $request){
        $datos_simcard = $request['dato'];
        $paquete = Paquete::find($datos_simcard["paquete"]);
        if($paquete != ""){
            $paquete->Actor_cedula = $datos_simcard["responsable_paquete"];
            $simcards = Simcard::where("Paquete_ID",'=',$paquete->ID)->get();
            $hoy = new DateTime();
            foreach($simcards as $simcard){
                $simcard->fecha_asignacion = $hoy;
                $simcard->save();
            }
            if($paquete->save() == true){
                return "EXITOSO";
            }else{
                return "FALLIDO";
            }
        }else{
            return "FALLIDO";
        }
    }
    
    public function eliminar_simcard(Request $request)
    {
        $ICC = $request['dato'];
        $simcard = Simcard::find($ICC);  
        if($simcard != null){
            $simcard->delete();
            return "EXITOSO";
        }else{
            return "FALLIDO";
        }
    }
    public function buscar_simcard(Request $request)
    {
        $pista = $request['dato'];
        $simcard = Simcard::where("ICC",'=',$pista)->orWhere("numero_linea","=",$pista)->first();
        if($simcard != ""){
            //OBTENER EL RESPONSABLE Y PAQUETE DE LA SIMCARD
            $paquete = Paquete::find($simcard->Paquete_ID);
            if($paquete != null){
                $Cedula_responsable = $paquete->Actor_cedula;
                $responsable = Actor::find($Cedula_responsable)->nombre;
                $simcard["responsable_simcard"] = $responsable;
                $simcard["paquete"] = $paquete->ID;
            }else{
                $simcard["responsable_simcard"] = "SIN ASIGNAR";
                $simcard["paquete"] = "SIN PAQUETE";
            }
            //OBTENER EL RESPONSABLE DE LA SIMCARD
            $hoy = new DateTime();
            $fecha_vencimiento = new DateTime($simcard->fecha_vencimiento);
            if($simcard->fecha_activacion != null){
                $fecha_activacion = new DateTime($simcard->fecha_activacion);    
                $interval = $hoy->diff($fecha_activacion);
                $meses = ($interval->format("%y")*12)+($interval->format("%m"));
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
            
            //OBTENER PLAN DE LA SIMCARD
            $Asignacion_Plan = Asignacion_Plan::where("Simcard_ICC", '=',$simcard->ICC)->first();
            if($Asignacion_Plan != ""){
                $simcard["plan"] = $Asignacion_Plan->Plan_codigo;
            }else{
                $simcard["plan"] = "SIN PLAN";
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
            if( $datos_simcard["Simcard_fecha_adjudicacion"] == null || $datos_simcard["Simcard_fecha_adjudicacion"] == "SIN ADJUDICAR"){
                $simcard->fecha_adjudicacion = null;
            }else{
                $simcard->fecha_adjudicacion = $datos_simcard["Simcard_fecha_adjudicacion"];
            }
            if( $datos_simcard["Simcard_fecha_activacion"] == null || $datos_simcard["Simcard_fecha_activacion"] == "SIN ACTIVAR"){
                $simcard->fecha_activacion = null;
            }else{
                $simcard->fecha_activacion = $datos_simcard["Simcard_fecha_activacion"];
            }
            if( $datos_simcard["Simcard_fecha_vencimiento"] == null){
                return "NO PUEDE DEJAR LA FECHA DE VENCIMIENTO VACIA";
            }else{
                $simcard->fecha_vencimiento = $datos_simcard["Simcard_fecha_vencimiento"];
            }
            if($datos_simcard["plan"] != "SIN PLAN"){
                $asignacion_plan = Asignacion_Plan::where("Simcard_ICC",'=',$simcard->ICC)->first();
                if($asignacion_plan != null){
                    $asignacion_plan->Plan_codigo = $datos_simcard["plan"];
                }else{
                    $asignacion_plan = new Asignacion_Plan();
                    $asignacion_plan->Plan_codigo = $datos_simcard["plan"];
                    $asignacion_plan->Simcard_ICC = $simcard->ICC;
                    if($asignacion_plan->save()){
                        return "EXITOSO";
                    }else{
                        return "FALLIDO";
                    }
                }
            }else{
                $asignacion_plan = Asignacion_Plan::where("Simcard_ICC",'=',$simcard->ICC)->first();
                if($asignacion_plan != null){
                    $asignacion_plan->delete();
                }
            }
            $simcard->save();
            return "EXITOSO";
        }else{
            return "FALLIDO";
        }
    }
    
    public function buscar_paquete(Request $request){
        $pista = $request['dato'];
        $simcard = Simcard::where("ICC",'=',$pista)->orWhere("numero_linea","=",$pista)->first();
        if($simcard != ""){
            $pista = $simcard->Paquete_ID;
        }
        $simcards = array();
        if($pista != ""){
            $simcards = Simcard::where("Paquete_ID",'=',$pista)->get();
            $hoy = new DateTime();
            foreach ($simcards as &$simcard) {
                $fecha_vencimiento = new DateTime($simcard->fecha_vencimiento);
                if($simcard->fecha_activacion != null){
                    $fecha_activacion = new DateTime($simcard->fecha_activacion);    
                    $interval = $hoy->diff($fecha_activacion);
                    $meses = ($interval->format("%y")*12)+($interval->format("%m"));
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
        }
        return $simcards;
    }

    public function empaquetar_simcard(Request $request){
        $dato = $request['dato'];
        $pista = $dato["pista"];
        $simcard = Simcard::where("ICC",'=',$pista)->orWhere("numero_linea","=",$pista)->first();
        if($simcard != ""){
            $simcard->Paquete_ID = $dato["numero_paquete"];
            $simcard->save();
            return "EXITOSO";
        }else{
            return "FALLIDO";
        }
    }
    
    public function crear_paquete(Request $request){
        $paquete = new Paquete();
        $datos_simcard = $request['dato'];
        $paquete->Actor_cedula = $datos_simcard["responsable"];
        if($paquete->save()){
            $pista = $datos_simcard["pista"];
            $simcard = Simcard::where("ICC",'=',$pista)->orWhere("numero_linea","=",$pista)->first();
            $simcard->Paquete_ID = $paquete->ID;
            if($simcard->save()){
                return "EXITOSO";
            }else{
                return "NO SE PUDO EMPAQUETAR LA SIMCARD";
            }
        }else{
            return "NO SE PUDO CREAR EL PAQUETE";
        }
    }
    
    public function eliminar_paquete(Request $request){
        $numero_paquete = $request['dato'];
        $simcards = Simcard::where("Paquete_ID",'=',$numero_paquete)->get();
        foreach($simcards as $simcard){
            $simcard->Paquete_ID = null;
            $simcard->save();
        }
        $paquete = Paquete::find($numero_paquete);
        $paquete->delete();
        return "EXITOSO";
    }
}