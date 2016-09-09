<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
 
use App\Actor;
use App\Jobs\SimcardFileUpload;
use App\Jobs\SimcardActivationFileUpload;
use App\Plan;
use App\Paquete;
use App\Notificacion;
use App\Asignacion_Plan;
use App\Asignacion_Permiso;
use DB;
use Queue;
use Log;
use Input;
use App\Simcard;
use App\Comision;
use App\File;
use DateTime;
use Excel;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class SimcardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $simcard = $request["simcard"]; 
        $data = array(); 
        $Actor = Auth::user()->actor;
        $permisos = $Actor->user->permisos;
        $lista_permisos = [];
        foreach ($permisos as $permiso) {
            array_push($lista_permisos,$permiso->permiso);
        }
        $Actor->lista_permisos = $lista_permisos;
        $data['Actor'] = $Actor;
        // CARGAR NOTIFICACIONES
        $data['notificaciones'] = Notificacion::where("Actor_cedula",$Actor->cedula)->where("descripcion","<>","")->get();
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
        $data["simcard"] = $simcard;    
        return View('general.simcard', $data);
        
        
    }

    public function legalizar_venta(Request $request){
        $datos = $request['dato'];
        $simcard = Simcard::find($datos["Simcard_ICC"]);
        if($simcard != null){
            $plan = Plan::find($datos["Plan_ID"]);
            if($plan != null){
                $asignacion = Asignacion_Plan::where("Simcard_ICC", $simcard->ICC)->first();
                if($asignacion == null){
                    $asignacion = new Asignacion_Plan();
                    $asignacion->Simcard_ICC = $simcard->ICC;
                }
                $asignacion->Plan_codigo = $plan->codigo;
                $asignacion->save();
                $simcard->fecha_venta = new DateTime();
                $simcard->numero_linea = $datos["Simcard_numero_linea"];
                $simcard->save();
                return "EXITOSO";
            }else{
                return "Plan no encontrado";
            }
        }else{
            return "Simcard no encontrada";
        }
    }
    
    public function buscar_venta(Request $request){
        $ICC = $request['dato'];
        $simcard = Simcard::find($ICC);
        $data = [];
        if($simcard != null){
            $asignacion = Asignacion_Plan::where("Simcard_ICC", $ICC)->first();
            if($asignacion != null){
                $Actor = Auth::user()->actor;
                $data["valor_primera_cuota"] = $asignacion->plan->valor*0.5*$Actor->porcentaje_postpago/$Actor->cantidad_cuotas;
                if($Actor->cantidad_cuotas > 1){
                    $data["valor_segunda_cuota"] = $asignacion->plan->valor*0.3*$Actor->porcentaje_postpago/$Actor->cantidad_cuotas;
                    if($Actor->cantidad_cuotas > 2){
                        $data["valor_tercera_cuota"] = $asignacion->plan->valor*0.1*$Actor->porcentaje_postpago/$Actor->cantidad_cuotas;
                        if($Actor->cantidad_cuotas > 3){
                            $data["valor_sexta_cuota"] = $asignacion->plan->valor*0.1*$Actor->porcentaje_postpago/$Actor->cantidad_cuotas;
                        }else{
                            $data["valor_sexta_cuota"] = 0;
                        }
                    }else{
                        $data["valor_tercera_cuota"] = 0;
                        $data["valor_sexta_cuota"] = 0;
                    }
                }else{
                    $data["valor_segunda_cuota"] = 0;
                    $data["valor_tercera_cuota"] = 0;
                    $data["valor_sexta_cuota"] = 0;
                }
                $data["fecha_venta"] = $simcard->fecha_venta;
                $data["primera_fecha"] = date('Y-m-d', strtotime("+1 months", strtotime($simcard->fecha_venta)));
                $data["segunda_fecha"] = date('Y-m-d', strtotime("+2 months", strtotime($simcard->fecha_venta)));
                $data["tercera_fecha"] = date('Y-m-d', strtotime("+3 months", strtotime($simcard->fecha_venta)));
                $data["sexta_fecha"] = date('Y-m-d', strtotime("+6 months", strtotime($simcard->fecha_venta)));
                
                // Revisar pagos
                $data["primera_comision"] = Comision::where("Simcard_ICC", $simcard->ICC)
                ->where(DB::raw('EXTRACT(YEAR_MONTH FROM fecha)'),
                date('Ym', strtotime("+1 months", strtotime($simcard->fecha_venta))))->first();
                $data["segunda_comision"] = Comision::where("Simcard_ICC", $simcard->ICC)
                ->where(DB::raw('EXTRACT(YEAR_MONTH FROM fecha)'),
                date('Ym', strtotime("+1 months", strtotime($simcard->fecha_venta))))->first();
                $data["tercera_comision"] = Comision::where("Simcard_ICC", $simcard->ICC)
                ->where(DB::raw('EXTRACT(YEAR_MONTH FROM fecha)'),
                date('Ym', strtotime("+1 months", strtotime($simcard->fecha_venta))))->first();
                $data["sexta_comision"] = Comision::where("Simcard_ICC", $simcard->ICC)
                ->where(DB::raw('EXTRACT(YEAR_MONTH FROM fecha)'),
                date('Ym', strtotime("+1 months", strtotime($simcard->fecha_venta))))->first();
            }
        }
        return $data;
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
        $permiso = Asignacion_Permiso::where("User_email",Auth::user()->email)->where("permiso", "INVENTARIOS")->first();
        if($permiso != null || Auth::user()->actor->jefe_cedula == null){
            $simcard = Simcard::with('paquete')->where(function($q) use ($pista) {
                    $q->where("ICC",$pista)->orWhere("numero_linea",$pista);
                })->first();
        }else{
            $simcard = Simcard::whereHas('paquete',function ($query){
                $query->where("Actor_cedula","=",Auth::user()->actor->cedula);
            })->where(function($q) use ($pista) {
                    $q->where("ICC",$pista)->orWhere("numero_linea",$pista);
                })->first();
        }
        if($simcard != ""){
            //OBTENER CLIENTE DE LA SIMCARD
            $simcard["cliente"] = $simcard->cliente;
            //OBTENER EQUIPOS DE LA SIMCARD
            $simcard["equipo"] = $simcard->equipo;
            //OBTENER EL RESPONSABLE Y PAQUETE DE LA SIMCARD
            $paquete = Paquete::find($simcard->Paquete_ID);
            if($paquete != null){
                $Cedula_responsable = $paquete->Actor_cedula;
                $responsable = Actor::find($Cedula_responsable)->nombre;
                $simcard["responsable_simcard"] = $responsable;
                $simcard["paquete_ID"] = $paquete->ID;
            }else{
                $simcard["responsable_simcard"] = "SIN ASIGNAR";
                $simcard["paquete_ID"] = "SIN PAQUETE";
            }
            //OBTENER EL ESTADO DE LA SIMCARD
            $simcard["color"] = Simcard::color_estado($simcard);
            
            //OBTENER PLAN DE LA SIMCARD
            if($simcard->categoria == "Prepago"){
                $simcard["plan"] = "Prepago";
            }else{
                $Asignacion_Plan = Asignacion_Plan::where("Simcard_ICC", '=',$simcard->ICC)->first();
                if($Asignacion_Plan != ""){
                    $simcard["plan"] = $Asignacion_Plan->Plan_codigo;
                }else{
                    $simcard["plan"] = "SIN PLAN";
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
                }
                if($asignacion_plan->save()){
                    return "EXITOSO";
                }else{
                    return "FALLIDO";
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
            foreach ($simcards as &$simcard) {
                $simcard["color"] = Simcard::color_estado($simcard);
            }
            $paquete = Paquete::find($pista);
            if($paquete != null){
                $data["simcards"] = $simcards;
                $permiso = Asignacion_Permiso::where("User_email",Auth::user()->email)->where("permiso", "INVENTARIOS")->first();
                if($paquete->Actor_cedula == Auth::user()->actor->cedula || $permiso != null || Auth::user()->actor->jefe_cedula == null){
                    $data["acceso"] = "SI";
                }else{
                    $data["acceso"] = "NO";
                }
                return $data;
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
            $hoy = new DateTime();
            $simcard->fecha_asignacion = $hoy;
            $simcard->save();
            return "EXITOSO";
        }else{
            return "FALLIDO";
        }
    }
    
    public function desempaquetar_simcard(Request $request){
        $icc = $request['icc'];
        $simcard = Simcard::find($icc);
        if($simcard != ""){
            $simcard->Paquete_ID = null;
            $simcard->save();
            return "EXITOSO";
        }else{
            return "FALLIDO";
        }
    }
    
    public function crear_paquete(Request $request){
        $paquete = new Paquete();
        $datos_simcard = $request['dato'];
        $pista = $datos_simcard["pista"];
        $simcard = Simcard::where("ICC",'=',$pista)->orWhere("numero_linea","=",$pista)->first();
        if($simcard != null){
            $paquete->Actor_cedula = $datos_simcard["responsable"];
            if($paquete->save()){
                $simcard->Paquete_ID = $paquete->ID;
                $hoy = new DateTime();
                $simcard->fecha_asignacion = $hoy;
                if($simcard->save()){
                    return "EXITOSO";
                }else{
                    return "NO SE PUDO EMPAQUETAR LA SIMCARD";
                }
            }else{
                return "NO SE PUDO CREAR EL PAQUETE";
            }
        }else{
            return "NO EXISTE LA SIMCARD";
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
    
    public function subir_archivo(Request $request){
        if ($request->hasFile('archivo_simcard'))
        {
            $tipo = $request->tipo_archivo;
            $Actor = Auth::user()->actor;
            $path = $request->file('archivo_simcard');
            $rows = Excel::selectSheetsByIndex(0)->load($path, function($reader) {})->get();
            if($tipo == "Agregar"){
                Queue::push(new SimcardFileUpload($rows,$Actor->cedula));
            }else{
                Queue::push(new SimcardActivationFileUpload($rows,$Actor->cedula));
            }
            return \Redirect::route('simcard')->with('subiendo_archivo' ,true);
            
        }
    }
}
