<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Actor;
use DB;
use App\Simcard;
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
        // CONTAR LAS SIMCARDS PREPAGO
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
        // CONTAR LAS SIMCARDS LIBRE
        // CONTAR LAS SIMCARDS POSTPAGO
        $data['Total_postpago'] = Simcard::whereHas('paquete', function ($query) {
                                        $query->where('Actor_cedula', '=', Auth::user()->Actor_cedula);
                                    })->where("categoria",'=','Postpago')->count();
        // CONTAR LAS SIMCARDS POSTPAGO
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
        // OBTENER COMISIONES POR MES
        // OBTENER ESTADO FINANCIERO
        $estado_financiero = Registro_Cartera::where("Actor_cedula", $actor->cedula)->sum(DB::raw("valor_unitario*cantidad"));
        // OBTENER ESTADO FINANCIERO
        $data['comisiones'] = $data_comisiones;
        $data["max_comision"] = round ($max_comision,-3);
        $data['estado_financiero'] = $estado_financiero;
        $data['Cantidad_notificaciones'] = 0;
        return View('home', $data);
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
