<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use App\Notificacion;
use Excel;
use App\File;
use App\Error;
use App\Fija;

class FijaFileUpload extends Job implements SelfHandling
{
    
    protected $rows;
    protected $cedula;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($rows, $cedula)
    {
        $this->rows = $rows;
        $this->cedula = $cedula;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $notificacion = new Notificacion();
        $notificacion->actor_cedula = $this->cedula;
        $notificacion->save();
        $notificacion_ID = $notificacion->ID;
        global $request,$counter_filas,$filas_buenas,$filas_malas,$msg;
        $counter_filas = 0; $filas_buenas = 0; $filas_malas=0; $msg = ""; $errores = "";
        $this->rows->each(function($row) use ($notificacion_ID) {
            global $request,$counter_filas,$filas_buenas,$filas_malas,$errores,$msg;
            try{
                if($row->peticion == null){
                    $error = new Error();
                    $error->Notificacion_ID = $notificacion_ID;
                    $error->descripcion = "archivo invalido";  
                    $error->save();
                    $filas_malas++;
                    return false;
                }else{
                    $counter_filas++;
                    $fecha_venta = $row->fecha_venta;
                    if($fecha_venta != null){
                        $fecha_venta = $fecha_venta->format('Y-m-d');
                    }
                    $fija = Fija::find($row->peticion);
                    if($fija == null){
                        $fija = new Fija();
                        $fija->peticion = $row->peticion;
                    }
                    $fija->Actor_cedula = $row->responsable_cedula;
                    $cliente = Cliente::find($row->cliente_identificacion);
                    if($cliente == null){
                        $cliente = new Cliente();
                        $cliente->identificacion = $row->cliente_identificacion;
                        $cliente->tipo = $row->cliente_tipo;
                        $cliente->nombre = $row->cliente_nombre;
                        $cliente->telefono = $row->cliente_telefono;
                        $cliente->correo = $row->cliente_correo;
                        $cliente->direccion = $row->cliente_direccion;
                        $ubicacion = Ubicacion::where("ciudad",$row->cliente_ciudad)->first();
                        if($ubicacion == null){
                            $ubicacion = new Ubicacion();
                            $ubicacion->region = $row->cliente_region;
                            $ubicacion->ciudad = $row->cliente_ciudad;
                            $ubicacion->save();
                        }
                        $ubicacion = Ubicacion::where("ciudad",$row->cliente_ciudad)->first();
                        $cliente->ubicacion_ID = $ubicacion->ID;
                        $cliente->save();
                    }
                    $fija->cliente_identificacion = $row->cliente_identificacion;
                    $fija->fecha_venta = $fecha_venta;
                    $fija->linea_base = $row->linea_base;
                    $fija->internet = $row->internet;
                    $fija->tv = $row->tv;
                    $fija->save();
                    $filas_buenas++;
                }
            }catch(\Exception $e){
                $error = new Error();
                $error->Notificacion_ID = $notificacion_ID;
                $error->descripcion = $counter_filas . ":" .  $e->getMessage();  
                $error->save();
                $filas_malas++;
            }
        });
        
        $notificacion->resultado = $errores;
        if($filas_malas == 0){
            $notificacion->descripcion = "Se añadieron " . $filas_buenas . " productos fijos";
            $notificacion->exito = true;
        }else{
            $notificacion->descripcion = "Se encontraron " . $filas_malas . " errores añadiendo productos fijos";
            $notificacion->exito = false;
        }
        $notificacion->save();
    }
}
