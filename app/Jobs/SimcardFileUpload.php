<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Simcard;
use App\Plan;
use App\Asignacion_Plan;
use App\Notificacion;
use App\Error;
use Excel;
use App\File;
use Illuminate\Contracts\Bus\SelfHandling;

class SimcardFileUpload extends Job implements SelfHandling
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
                $counter_filas++;
                $fecha_vencimiento = $row->fecha_vencimiento;
                if($fecha_vencimiento != null){
                    $fecha_vencimiento = $fecha_vencimiento->format('Y-m-d');
                }
                $fecha_adjudicacion = $row->fecha_adjudicacion;
                if($fecha_adjudicacion != null){
                    $fecha_adjudicacion = $fecha_adjudicacion->format('Y-m-d');
                }
                $fecha_activacion = $row->fecha_activacion;
                if($fecha_activacion != null){
                    $fecha_activacion = $fecha_activacion->format('Y-m-d');
                }
                $fecha_asignacion = $row->fecha_asignacion;
                if($fecha_asignacion != null){
                    $fecha_asignacion = $fecha_asignacion->format('Y-m-d');
                }
                $simcard = Simcard::find($row->icc);
                if($simcard == null){
                    $simcard = new Simcard();
                    $simcard->ICC = $row->icc;
                }
                $simcard->numero_linea = $row->numero_linea;
                $simcard->categoria = $row->tipo;
                $simcard->fecha_adjudicacion = $fecha_adjudicacion;
                $simcard->fecha_activacion = $fecha_activacion;
                $simcard->fecha_asignacion = $fecha_asignacion;
                $simcard->paquete_id = $row->paquete_id;
                $simcard->cliente_identificacion = $row->cliente_identificacion;
                $simcard->fecha_vencimiento = $fecha_vencimiento;
                $simcard->save();
                $cod_plan = $row->plan;
                if($cod_plan != null){
                    $asignacion = new Asignacion_Plan();
                    $asignacion->Simcard_ICC = $row->icc;
                    $asignacion->Plan_codigo = $cod_plan;
                    $asignacion->save();
                }
                $filas_buenas++;
            }catch(\Exception $e){
                $error = new Error();
                $error->Notificacion_ID = $notificacion_ID;
                $error->descripcion = $counter_filas . ":" .  $e->getMessage();  
                $error->save();
                $filas_malas++;
            }
        });
        if($filas_malas == 0){
            $notificacion->descripcion = "Se añadieron " . $filas_buenas . "simcards";
            $notificacion->exito = true;
        }else{
            $notificacion->descripcion = "Se encontraron " . $filas_malas . " errores añadiendo simcards";
            $notificacion->exito = false;
        }
        $notificacion->save();
    }
    
    public function failed()
    {
        var_dump("FAILED");
    }
}
