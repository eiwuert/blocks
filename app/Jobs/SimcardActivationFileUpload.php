<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Simcard;
use App\Notificacion;
use App\Error;
use Excel;
use App\File;
use Illuminate\Contracts\Bus\SelfHandling;

class SimcardActivationFileUpload extends Job implements SelfHandling
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
                $fecha_activacion = $row->fecha_activacion;
                if($fecha_activacion != null){
                    $fecha_activacion = $fecha_activacion->format('Y-m-d');
                }
                
                $simcard = Simcard::find($row->icc);
                if($simcard == null){
                    $error = new Error();
                    $error->Notificacion_ID = $notificacion_ID;
                    $error->descripcion = $counter_filas . ": La simcard no fue encontrada";  
                    $error->save();
                    $filas_malas++; 
                }else{
                   $simcard->fecha_activacion = $fecha_activacion;
                   $simcard->save();
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
            $notificacion->descripcion = "Se activaron " . $filas_buenas . " simcards";
            $notificacion->exito = true;
        }else{
            $notificacion->descripcion = "Se encontraron " . $filas_malas . " errores activando simcards";
            $notificacion->exito = false;
        }
        $notificacion->save();
    }
}
