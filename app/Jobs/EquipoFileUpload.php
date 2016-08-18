<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use App\Notificacion;
use Excel;
use App\File;
use App\Error;
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
        $notificacion = new Notificacion();
        $notificacion->actor_cedula = $this->cedula;
        $notificacion->save();
        $notificacion_ID = $notificacion->ID;
        global $request,$counter_filas,$filas_buenas,$filas_malas,$msg;
        $counter_filas = 0; $filas_buenas = 0; $filas_malas=0; $msg = ""; $errores = "";
        $this->rows->each(function($row) use ($notificacion_ID) {
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
                $equipo = Equipo::find($row->equipo_imei);
                if($equipo == null){
                    $equipo = new Equipo();
                    $equipo->IMEI = $row->equipo_imei;
                }
                $equipo->Actor_cedula = $row->responsable_cedula;
                $equipo->simcard_ICC = $row->simcard_ICC;
                $equipo->cliente_identificacion = $row->cliente_identificacion;
                $equipo->fecha_venta = $row->$fecha_venta;
                $equipo->Descripcion_Equipo_cod_scl = $row->cod_scl;
                $equipo->descripcion_precio = $row->precio;
                $equipo->fecha_asignacion = $fecha_asignacion;
                $equipo->save();
                $filas_buenas++;
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
            $notificacion->descripcion = "Se añadieron " . $filas_buenas . " equipos";
            $notificacion->exito = true;
        }else{
            $notificacion->descripcion = "Se encontraron " . $filas_malas . " errores añadiendo equipos";
            $notificacion->exito = false;
        }
        $notificacion->save();
    }
}
