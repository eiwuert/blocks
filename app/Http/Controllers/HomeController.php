<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Actor;
use DB;
use App\Simcard;
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
        
        $data = array();
        $data['Actor'] = Auth::user()->actor;
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
