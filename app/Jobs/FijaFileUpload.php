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
                    $fija->cliente_identificacion = $row->cliente_identificacion;
                    $fija->fecha_venta = $fecha_venta;
                    $fija->tipo_producto = $row->tipo_producto;
                    $fija->nombre_producto = $row->nombre_producto;
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
