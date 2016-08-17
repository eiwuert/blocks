<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Simcard;
use Excel;
use App\File;
use Illuminate\Contracts\Bus\SelfHandling;

class SimcardFileUpload extends Job implements SelfHandling
{
    protected $rows;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($rows)
    {
        $this->rows = $rows;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   
        global $request,$counter_filas,$filas_buenas,$filas_malas,$errores,$msg;
        $counter_filas = 0; $filas_buenas = 0; $filas_malas=0; $msg = ""; $errores = "";
        $this->rows->each(function($row) {
            global $request,$counter_filas,$filas_buenas,$filas_malas,$errores,$msg;
            try{
                $counter_filas++;
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
                $simcard = new Simcard(array("ICC" => $row->icc, "numero_linea" => $row->numero_linea,"categoria" => $row->tipo ,"fecha_adjudicacion" => $fecha_adjudicacion,"fecha_activacion" => $fecha_activacion,"fecha_asignacion" => $fecha_asignacion,"paquete_ID" => $row->paquete_id,"Cliente_identificacion" => $row->cliente_identificacion));
                $simcard->save();
                $filas_buenas++;
            }catch(\Exception $e){
                if($e->getCode() == 23000){
                    $errores = $errores . $counter_filas . ":  ICC ya registrada\n"; 
                }else{
                    $errores = $errores . $counter_filas . ": " . $e->getMessage() ."\n";    
                }
                $filas_malas++;
            }
        });
        var_dump("Filas buenas: " . $filas_buenas);
        var_dump("Errores: " . $errores);
    }
    
    public function failed()
    {
        var_dump("FAILED");
    }
}
