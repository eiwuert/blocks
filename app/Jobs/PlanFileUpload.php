<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Plan;
use App\Notificacion;
use App\Error;
use Excel;
use App\File;
use Illuminate\Contracts\Bus\SelfHandling;
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Queue;

class PlanFileUpload extends Job implements SelfHandling
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
        global $request,$counter_filas,$filas_buenas,$filas_malas,$errores,$msg;
        $counter_filas = 0; $filas_buenas = 0; $filas_malas=0; $msg = ""; $errores = "";
        $this->rows->each(function($row)  use ($notificacion_ID){
            global $request,$counter_filas,$filas_buenas,$filas_malas,$errores,$msg;
            try{
                if($row->cod_scl == null){
                    $error = new Error();
                    $error->Notificacion_ID = $notificacion_ID;
                    $error->descripcion = "Archivo no valido";  
                    $error->save();
                    $filas_malas++; 
                    return false;
                }else{
                    $plan = Plan::find($row->cod_scl);
                    if($plan == null){
                        $plan = new Plan();
                        $plan->codigo = $row->cod_scl;
                    }
                    $plan->cantidad_datos = $row->datos;
                    $plan->cantidad_minutos = $row->minutos;
                    $plan->valor = $row->valor;
                    $plan->save();
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
        if($filas_malas == 0){
            $notificacion->descripcion = "Se añadieron " . $filas_buenas . " planes";
            $notificacion->exito = true;
        }else{
            $notificacion->descripcion = "Se encontraron " . $filas_malas . " errores añadiendo planes";
            $notificacion->exito = false;
        }
        $notificacion->save();
    }
}
