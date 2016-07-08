<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Actor;
use DB;
use App\Simcard;
use App\Equipo;
use App\Comision;
use App\Registro_Cartera;
use Auth;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        setlocale(LC_MONETARY, 'es_CO');
        $data = array();
        $actor = Auth::user()->actor;
        $data['Actor'] = $actor;
        $data['Cantidad_notificaciones'] = 0;
        if($actor->jefe != null){
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
                          ->orWhere(DB::raw("DATEDIFF(CURRENT_DATE,fecha_vencimiento)"), '>=', 0);
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
                          ->orWhere(DB::raw("DATEDIFF(CURRENT_DATE,fecha_vencimiento)"), '>=', 0);
                })->count();
            // CONTAR LAS SIMCARDS POSTPAGO
            $data['Total_postpago'] = Simcard::whereHas('paquete', function ($query) {
                                            $query->where('Actor_cedula', '=', Auth::user()->Actor_cedula);
                                        })->where("categoria",'=','Postpago')->count();
            // OBTENER INVENTARIOS
            $data_inventarios = [];
            $max_inventarios = 0;
                // PREPAGO
                $inventario["y"] = "Prepago";
                $inventario["Inventario"] = $simcard = Simcard::whereHas('paquete',function ($query){
                                $query->where("Actor_cedula","=",Auth::user()->actor->cedula);
                            })->whereNull("Cliente_identificacion")->where("categoria",'=','Prepago')->count();
                if($inventario["Inventario"] > $max_inventarios) $max_inventarios = $inventario["Inventario"]; 
                $inventario["Vendidas"] = $simcard = Simcard::whereHas('paquete',function ($query){
                                $query->where("Actor_cedula","=",Auth::user()->actor->cedula);
                            })->whereNotNull("Cliente_identificacion")->where("categoria",'=','Prepago')->count();
                if($inventario["Vendidas"] > $max_inventarios) $max_inventarios = $inventario["Vendidas"]; 
            array_push($data_inventarios, $inventario);     
                // LIBRE
                $inventario["y"] = "Libre";
                $inventario["Inventario"] = $simcard = Simcard::whereHas('paquete',function ($query){
                                $query->where("Actor_cedula","=",Auth::user()->actor->cedula);
                            })->whereNull("Cliente_identificacion")->where("categoria",'=','Libre')->count();
                if($inventario["Inventario"] > $max_inventarios) $max_inventarios = $inventario["Inventario"]; 
                $inventario["Vendidas"] = $simcard = Simcard::whereHas('paquete',function ($query){
                                $query->where("Actor_cedula","=",Auth::user()->actor->cedula);
                            })->whereNotNull("Cliente_identificacion")->where("categoria",'=','Libre')->count();
                if($inventario["Vendidas"] > $max_inventarios) $max_inventarios = $inventario["Vendidas"]; 
            array_push($data_inventarios, $inventario);    
                // POSTPAGO
                $inventario["y"] = "Postpago";
                $inventario["Inventario"] = $simcard = Simcard::whereHas('paquete',function ($query){
                                $query->where("Actor_cedula","=",Auth::user()->actor->cedula);
                            })->whereNull("Cliente_identificacion")->where("categoria",'=','Postpago')->count();
                if($inventario["Inventario"] > $max_inventarios) $max_inventarios = $inventario["Inventario"]; 
                $inventario["Vendidas"] = $simcard = Simcard::whereHas('paquete',function ($query){
                                $query->where("Actor_cedula","=",Auth::user()->actor->cedula);
                            })->whereNotNull("Cliente_identificacion")->where("categoria",'=','Postpago')->count();
                if($inventario["Vendidas"] > $max_inventarios) $max_inventarios = $inventario["Vendidas"]; 
            array_push($data_inventarios, $inventario);
                // EQUIPOS
                $inventario["y"] = "Equipos";
                $inventario["Inventario"] = Equipo::where("Actor_cedula","=",Auth::user()->actor->cedula)->whereNull("Cliente_identificacion")->count();
                if($inventario["Inventario"] > $max_inventarios) $max_inventarios = $inventario["Inventario"]; 
                $inventario["Vendidas"] = Equipo::where("Actor_cedula","=",Auth::user()->actor->cedula)->whereNotNull("Cliente_identificacion")->count();
                if($inventario["Vendidas"] > $max_inventarios) $max_inventarios = $inventario["Vendidas"]; 
            array_push($data_inventarios, $inventario); 
            // OBTENER COMISIONES POR MES
            $paquetes = $actor->paquetes;
            $comisiones = DB::table('Actor')
                ->join('Paquete', 'Paquete.Actor_cedula', '=', 'Actor.cedula')
                ->join('Simcard', 'Simcard.Paquete_ID', '=', 'Paquete.ID')
                ->join('Comision', 'Comision.Simcard_ICC', '=', 'Simcard.ICC')
                ->select(DB::raw('YEAR(Comision.fecha) as anho'),DB::raw('MONTH(Comision.fecha) as mes'),"Simcard.categoria",DB::raw('sum(Comision.valor) as total'))
                ->where('Actor_cedula',$actor->cedula)
                ->groupBy(DB::raw('YEAR(Comision.fecha)'),DB::raw('MONTH(Comision.fecha)'), "Simcard.categoria")
                ->orderBy(DB::raw('YEAR(Comision.fecha)'),DB::raw('MONTH(Comision.fecha)'), 'desc')
                ->take(9)
                ->get();
            $aux = [];
            foreach ($comisiones as $comision) {
                $periodo = $comision->anho . "-" . $comision->mes;
                $aux[$periodo][$comision->categoria] = $comision->total;
            }
            $data_comisiones = [];
            $max_comision = 0;
            while ($raw = current($aux)) {
                $obj["y"] = key($aux);
                if(array_key_exists ("Prepago",$raw)){
                    $obj["prepago"] = $raw["Prepago"]*$actor->porcentaje_prepago;
                    if($obj["prepago"] > $max_comision)$max_comision = $obj["prepago"];
                }else{
                    $obj["prepago"] = 0;
                }
                if(array_key_exists ("Libre",$raw)){
                    $obj["libre"] = $raw["Libre"]*$actor->porcentaje_libre;
                    if($obj["libre"] > $max_comision)$max_comision = $obj["libre"];
                }else{
                    $obj["libre"] = 0;
                }
                if(array_key_exists ("Postpago",$raw)){
                    $obj["postpago"] = $raw["Postpago"]*$actor->porcentaje_postpago;
                    if($obj["postpago"] > $max_comision)$max_comision = $obj["postpago"];
                }else{
                    $obj["postpago"] = 0;
                }
                array_push($data_comisiones, $obj);
                next($aux);
            }
            // OBTENER ESTADO FINANCIERO
            $estado_financiero = Registro_Cartera::where("Actor_cedula", $actor->cedula)->sum(DB::raw("valor_unitario*cantidad"));
            // RETORNAR VALORES
            $data['comisiones'] = $data_comisiones;
            $data['inventarios'] = $data_inventarios;
            $data["max_comision"] = round ($max_comision,-3);
            $data['estado_financiero'] = $estado_financiero;
            $data['Cantidad_notificaciones'] = 0;
            $data["max_inventarios"] = round ($max_inventarios,-3);
            return View('employee.home', $data);    
        }else{
            // OBTENER TORTAS
                // CONTAR LAS SIMCARDS PREPAGO
                $data['Total_prepago'] = Simcard::where("categoria",'Prepago')->whereNull('fecha_activacion')->where(DB::raw("DATEDIFF(CURRENT_DATE,fecha_vencimiento)"), '>', 0)->count();
                
                $data['Total_prepago_activas'] = Simcard::where("categoria",'Prepago')->where(DB::raw("ROUND(DATEDIFF(CURRENT_DATE,fecha_activacion)/30)"), '<', 6)->count();
                
                $data['Total_prepago_vencidas'] = Simcard::with('paquete')->where("categoria",'=','Prepago')->where(function ($query) {
                        $query->where(DB::raw("ROUND(DATEDIFF(CURRENT_DATE,fecha_activacion)/30)"), '>=', 6)
                              ->orWhere(DB::raw("DATEDIFF(CURRENT_DATE,fecha_vencimiento)"), '>=', 0);
                    })->count();
                // CONTAR LAS SIMCARDS LIBRE
                $data['Total_libres'] = Simcard::with('paquete')->where("categoria",'Libre')->whereNull('fecha_activacion')->where(DB::raw("DATEDIFF(CURRENT_DATE,fecha_vencimiento)"), '>', 0)->count();
                
                $data['Total_libres_activas'] = Simcard::with('paquete')->where("categoria",'Libre')->where(DB::raw("ROUND(DATEDIFF(CURRENT_DATE,fecha_activacion)/30)"), '<', 6)->count();
                
                $data['Total_libres_vencidas'] = Simcard::with('paquete')->where("categoria",'Libre')->where(function ($query) {
                        $query->where(DB::raw("ROUND(DATEDIFF(CURRENT_DATE,fecha_activacion)/30)"), '>=', 6)
                              ->orWhere(DB::raw("DATEDIFF(CURRENT_DATE,fecha_vencimiento)"), '>=', 0);
                    })->count();
            // CONTAR LAS SIMCARDS POSTPAGO
            $data['Total_postpago'] = Simcard::with('paquete')->where("categoria",'Postpago')->count();
            // OBTENER INVENTARIOS
            $data_inventarios = [];
            $max_inventarios = 0;
                // PREPAGO
                $inventario["y"] = "Prepago";
                $inventario["Inventario"] = Simcard::whereHas('paquete',function ($query){
                                                $query->whereNull("Actor_cedula");
                                            })->whereNull("Cliente_identificacion")->where("categoria",'=','Prepago')->count();
                if($inventario["Inventario"] > $max_inventarios) $max_inventarios = $inventario["Inventario"]; 
                $inventario["Asignadas"] = Simcard::whereHas('paquete',function ($query){
                                                $query->whereNotNull("Actor_cedula");
                                            })->whereNull("Cliente_identificacion")->where("categoria",'=','Prepago')->count();
                if($inventario["Asignadas"] > $max_inventarios) $max_inventarios = $inventario["Asignadas"]; 
                $inventario["Vendidas"] = Simcard::whereNotNull("Cliente_identificacion")->where("categoria",'=','Prepago')->count();
                if($inventario["Vendidas"] > $max_inventarios) $max_inventarios = $inventario["Vendidas"]; 
            array_push($data_inventarios, $inventario);     
                // LIBRE
                $inventario["y"] = "Libre";
                $inventario["Inventario"] = Simcard::whereHas('paquete',function ($query){
                                                $query->whereNull("Actor_cedula");
                                            })->whereNull("Cliente_identificacion")->where("categoria",'=','Libre')->count();
                if($inventario["Inventario"] > $max_inventarios) $max_inventarios = $inventario["Inventario"]; 
                $inventario["Asignadas"] = Simcard::whereHas('paquete',function ($query){
                                                $query->whereNotNull("Actor_cedula");
                                            })->whereNull("Cliente_identificacion")->where("categoria",'=','Libre')->count();
                if($inventario["Asignadas"] > $max_inventarios) $max_inventarios = $inventario["Asignadas"]; 
                $inventario["Vendidas"] =  Simcard::whereNotNull("Cliente_identificacion")->where("categoria",'=','Libre')->count();
                if($inventario["Vendidas"] > $max_inventarios) $max_inventarios = $inventario["Vendidas"]; 
            array_push($data_inventarios, $inventario);    
                // POSTPAGO
                $inventario["y"] = "Postpago";
                $inventario["Inventario"] = Simcard::whereHas('paquete',function ($query){
                                                $query->whereNull("Actor_cedula");
                                            })->whereNull("Cliente_identificacion")->where("categoria",'=','Postpago')->count();
                if($inventario["Inventario"] > $max_inventarios) $max_inventarios = $inventario["Inventario"]; 
                $inventario["Asignadas"] = Simcard::whereHas('paquete',function ($query){
                                                $query->whereNotNull("Actor_cedula");
                                            })->whereNull("Cliente_identificacion")->where("categoria",'=','Postpago')->count();
                if($inventario["Asignadas"] > $max_inventarios) $max_inventarios = $inventario["Asignadas"]; 
                $inventario["Vendidas"] = $simcard = Simcard::whereNotNull("Cliente_identificacion")->where("categoria",'=','Postpago')->count();
                if($inventario["Vendidas"] > $max_inventarios) $max_inventarios = $inventario["Vendidas"]; 
                
            array_push($data_inventarios, $inventario);
                // EQUIPOS
                $inventario["y"] = "Equipos";
                $inventario["Inventario"] = Equipo::whereNull("Actor_cedula")->whereNull("Cliente_identificacion")->count();
                if($inventario["Inventario"] > $max_inventarios) $max_inventarios = $inventario["Inventario"]; 
                $inventario["Vendidas"] = Equipo::whereNotNull("Cliente_identificacion")->count();
                if($inventario["Vendidas"] > $max_inventarios) $max_inventarios = $inventario["Vendidas"];  
                $inventario["Asignadas"] = Equipo::whereNotNull("Actor_cedula")->whereNull("Cliente_identificacion")->count();
                if($inventario["Asignadas"] > $max_inventarios) $max_inventarios = $inventario["Asignadas"];
            array_push($data_inventarios, $inventario); 
            // OBTENER COMISIONES POR MES
            
            $comisiones = DB::table('Actor')
                ->join('Paquete', 'Paquete.Actor_cedula', '=', 'Actor.cedula')
                ->join('Simcard', 'Simcard.Paquete_ID', '=', 'Paquete.ID')
                ->join('Comision', 'Comision.Simcard_ICC', '=', 'Simcard.ICC')
                ->select(DB::raw('YEAR(Comision.fecha) as anho'),DB::raw('MONTH(Comision.fecha) as mes'),"Simcard.categoria",DB::raw('sum(Comision.valor) as total'))
                ->where('Actor_cedula',$actor->cedula)
                ->groupBy(DB::raw('YEAR(Comision.fecha)'),DB::raw('MONTH(Comision.fecha)'), "Simcard.categoria")
                ->orderBy(DB::raw('YEAR(Comision.fecha)'),DB::raw('MONTH(Comision.fecha)'), 'desc')
                ->take(9)
                ->get();
            $aux = [];
            foreach ($comisiones as $comision) {
                $periodo = $comision->anho . "-" . $comision->mes;
                $aux[$periodo][$comision->categoria] = $comision->total;
            }
            $data_comisiones = [];
            $max_comision = 0;
            while ($raw = current($aux)) {
                $obj["y"] = key($aux);
                if(array_key_exists ("Prepago",$raw)){
                    $obj["prepago"] = $raw["Prepago"]*$actor->porcentaje_prepago;
                    if($obj["prepago"] > $max_comision)$max_comision = $obj["prepago"];
                }else{
                    $obj["prepago"] = 0;
                }
                if(array_key_exists ("Libre",$raw)){
                    $obj["libre"] = $raw["Libre"]*$actor->porcentaje_libre;
                    if($obj["libre"] > $max_comision)$max_comision = $obj["libre"];
                }else{
                    $obj["libre"] = 0;
                }
                if(array_key_exists ("Postpago",$raw)){
                    $obj["postpago"] = $raw["Postpago"]*$actor->porcentaje_postpago;
                    if($obj["postpago"] > $max_comision)$max_comision = $obj["postpago"];
                }else{
                    $obj["postpago"] = 0;
                }
                array_push($data_comisiones, $obj);
                next($aux);
            }
            // OBTENER ESTADO FINANCIERO
            $estado_financiero = Registro_Cartera::where("Actor_cedula", $actor->cedula)->sum(DB::raw("valor_unitario*cantidad"));
            // RETORNAR VALORES
            $data['comisiones'] = $data_comisiones;
            $data['inventarios'] = $data_inventarios;
            $data["max_comision"] = round ($max_comision,-3);
            $data['estado_financiero'] = $estado_financiero;
            $data['Cantidad_notificaciones'] = 0;
            $data["max_inventarios"] = round ($max_inventarios,-3);
            return View('admin.home', $data);    
        }
        
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
