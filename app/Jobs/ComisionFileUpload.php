<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use App\Notificacion;
use Excel;
use App\File;
use App\Error;
use App\Comision;
use App\Simcard;
use App\Cliente;
use App\Ubicacion;
use App\Equipo;

class ComisionFileUpload extends Job implements SelfHandling
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
                $fecha = $row->fecha;
                if($fecha != null){
                    $fecha = $fecha->format('Y-m-d');
                }
                $comision = new Comision();
                $comision->valor = $row->valor;
                $comision->fecha = $fecha;
                $simcard = Simcard::where("numero_linea",$row->numero_telefono);
                var_dump($row->numero_telefono);
                if($simcard != null){
                    $comision->Simcard_ICC = $simcard->icc;        
                    $cliente = Cliente::find($row->cliente_identificacion);
                    if($cliente == null){
                        $cliente = new Cliente();
                        $cliente->identificacion = $row->cliente_identificacion;
                        $cliente->tipo = $row->cliente_tipo;
                        $cliente->nombre = $row->cliente_nombre;
                        $cliente->telefono = $row->cliente_telefono;
                        $cliente->correo = $row->cliente_correo;
                        $cliente->direccion = $row->cliente_direccion;
                        $ubicacion = Ubicacion::where("ciudad",$row->cliente_ubicacion);
                        if($ubicacion != null){
                            $cliente->ubicacion_ID = $ubicacion->ID;
                        }
                        $cliente->save();
                    }
                    $simcard->cliente_identificacion = $row->cliente_identificacion;
                    $simcard->save();
                    if($row->imei != null){
                        $equipo = Equipo::find($row->imei);
                        if($equipo != null){
                            $comision->Equipo_IMEI = $equipo->imei;        
                            $equipo->simcard_ICC = $comision->Simcard_ICC;
                            $equipo->cliente_identificacion = $row->cliente_identificacion;
                            $equipo->save();
                        }
                    }
                }else{
                    $error = new Error();
                    $error->Notificacion_ID = $notificacion_ID;
                    $error->descripcion = $counter_filas . ":" .  $e->getMessage();  
                    $error->save();
                    $filas_malas++;
                }
                $comision->save();
                $filas_buenas++;
            }catch(\Exception $e){
                $error = new Error();
                $error->Notificacion_ID = $notificacion_ID;
                $error->descripcion = $counter_filas . ": Simcard no encontrada";  
                $error->save();
                $filas_malas++;
            }
        });
        
        $notificacion->resultado = $errores;
        if($filas_malas == 0){
            $notificacion->descripcion = "Se añadieron " . $filas_buenas . " comisiones";
            $notificacion->exito = true;
        }else{
            $notificacion->descripcion = "Se encontraron " . $filas_malas . " errores añadiendo comisiones";
            $notificacion->exito = false;
        }
        $notificacion->save();
    }
}
