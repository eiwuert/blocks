<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use App\Notificacion;
use Excel;
use App\File;
use App\Equipo;

class EquipoFileUpload extends Job implements SelfHandling
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
        global $request,$counter_filas,$filas_buenas,$filas_malas,$errores,$msg;
        $counter_filas = 0; $filas_buenas = 0; $filas_malas=0; $msg = ""; $errores = "";
        $this->rows->each(function($row) {
            global $request,$counter_filas,$filas_buenas,$filas_malas,$errores,$msg;
            try{
                $counter_filas++;
                $fecha_asignacion = $row->fecha_asignacion;
                if($fecha_asignacion != null){
                    $fecha_asignacion = $fecha_asignacion->format('Y-m-d');
                }
                $fecha_venta = $row->fecha_venta;
                if($fecha_venta != null){
                    $fecha_venta = $fecha_venta->format('Y-m-d');
                }
                $equipo = new Equipo(array('IMEI' => $row->IMEI,'Actor_cedula' => $row->responsable_cedula,'Simcard_ICC' => $row->Simcard_ICC, 'Cliente_identificacion' => $row->Cliente_identificacion,'fecha_venta' => $fecha_venta,'Descripcion_Equipo_cod_scl' => $row->cod_scl,'descripcion_precio' => $row->precio,'fecha_asignacion' => $fecha_asignacion));
                $equipo->save();
                $filas_buenas++;
            }catch(\Exception $e){
                if($e->getCode() == 23000){
                    $errores = $errores . $counter_filas . ";  IMEI ya registrado\n"; 
                }else{
                    $errores = $errores . $counter_filas . "; " . $e->getMessage() ."\n";    
                }
                $filas_malas++;
            }
        });
        $notificacion = new Notificacion();
        $notificacion->actor_cedula = $this->cedula;
        $notificacion->resultado = $errores;
        if($filas_malas == 0){
            $notificacion->descripcion = "Se añadieron " . $filas_buenas . "equipos";
            $notificacion->exito = true;
        }else{
            $notificacion->descripcion = "Se encontraron " . $filas_malas . " errores añadiendo equipos";
            $notificacion->exito = false;
        }
        $notificacion->save();
    }
}
