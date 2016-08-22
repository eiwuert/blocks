<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use App\Notificacion;
use Excel;
use App\File;
use App\Error;
use App\Descripcion_Equipo;

class DescripcionEquipoFileUpload extends Job implements SelfHandling
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
                if($row->cod_scl == null){
                    $error = new Error();
                    $error->Notificacion_ID = $notificacion_ID;
                    $error->descripcion = "archivo invalido";  
                    $error->save();
                    $filas_malas++;
                    return false;
                }else{
                    $counter_filas++;
                    $descripcion = Descripcion_Equipo::find($row->cod_scl);
                    if($descripcion == null){
                        $descripcion = new Descripcion_Equipo();
                        $descripcion->cod_scl = $row->cod_scl;
                    }
                    $descripcion->tecnologia = $row->tecnologia;
                    $descripcion->modelo = $row->modelo;
                    $descripcion->precio_prepago = $row->precio_prepago;
                    $descripcion->precio_contado = $row->precio_contado;
                    $descripcion->precio_3_cuotas = $row->precio_3_cuotas;
                    $descripcion->precio_6_cuotas = $row->precio_6_cuotas;
                    $descripcion->precio_12_cuotas = $row->precio_12_cuotas;
                    $descripcion->precio_24_cuotas = $row->precio_24_cuotas;
                    $descripcion->save();
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
            $notificacion->descripcion = "Se añadieron " . $filas_buenas . " descripciones de equipos";
            $notificacion->exito = true;
        }else{
            $notificacion->descripcion = "Se encontraron " . $filas_malas . " errores añadiendo descripciones de equipos";
            $notificacion->exito = false;
        }
        $notificacion->save();
    }
}
