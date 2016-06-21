<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Plan;
use App\Asignacion_Plan;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    public function buscar_plan(Request $request){
        $codigo = $request["dato"];
        $plan = Plan::find($codigo);
        return $plan;
    }
    
    public function crear_plan(Request $request){
        $datos_plan = $request["dato"];
        $plan = Plan::find($datos_plan["Plan_codigo"]);
        if($plan == null){
            $plan = new Plan();
            $plan->codigo =$datos_plan["Plan_codigo"];
            $plan->cantidad_minutos = $datos_plan["Plan_minutos"];
            $plan->cantidad_datos = $datos_plan["Plan_datos"];
            $plan->valor = $datos_plan["Plan_valor"];
            $plan->save();
            return "EXITOSO";
        }else{
            return "EL CODIGO YA SE ENCUENTRA REGISTRADO";
        }
    }
    public function actualizar_plan(Request $request){
        $datos_plan = $request["dato"];
        $codigo = $datos_plan["Plan_codigo"];
        $codigo_nuevo = $datos_plan["Plan_codigo_nuevo"];
        $plan = Plan::find($codigo_nuevo);
        if($codigo == $codigo_nuevo){
            $plan->cantidad_minutos = $datos_plan["Plan_minutos"];
            $plan->cantidad_datos = $datos_plan["Plan_datos"];
            $plan->valor = $datos_plan["Plan_valor"];
            $plan->save();
            return "EXITOSO";
        }else{
            if($plan == null){
                $plan = Plan::find($codigo);
                $plan_nuevo = new Plan();
                $plan_nuevo->codigo = $codigo_nuevo;
                $plan_nuevo->cantidad_minutos = $datos_plan["Plan_minutos"];
                $plan_nuevo->cantidad_datos = $datos_plan["Plan_datos"];
                $plan_nuevo->valor = $datos_plan["Plan_valor"];
                $plan_nuevo->save();
                $asignaciones = Asignacion_Plan::where("Plan_codigo","=",$codigo)->get();
                foreach($asignaciones as $asignacion){
                    $asignacion->Plan_codigo = $codigo_nuevo;
                    $asignacion->save();
                }
                $plan->delete();
                return "EXITOSO";
            }else{
               return "EL CODIGO YA SE ENCUENTRA REGISTRADO"; 
            }
        }
    }
    
    public function eliminar_plan(Request $request){
        $codigo = $request["dato"];
        $plan = Plan::find($codigo);
        if($plan != null){
            $plan = Plan::find($codigo);
            $asignaciones = Asignacion_Plan::where("Plan_codigo","=",$codigo)->get();
            foreach($asignaciones as $asignacion){
                $asignacion->delete();
            }
            $plan->delete();
            return "EXITOSO";
        }else{
           return "PlAN NO ENCONTRADO"; 
        }
    }
}
