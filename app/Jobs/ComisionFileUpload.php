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
                $simcard = Simcard::where("numero_linea",$row->numero_telefono)->first();
                if($simcard != null){
                    if($simcard->categoria = "Postpago"){
                        $fecha_comision = date('Ym', strtotime($fecha));
                        $fecha_venta = date('Ym', strtotime("+1 months", strtotime($simcard->fecha_venta)));
                        if($fecha_comision == $fecha_venta){
                            $simcard->primer_pago = true;
                        }
                        $fecha_venta = date('Ym', strtotime("+2 months", strtotime($simcard->fecha_venta)));
                        if($fecha_comision == $fecha_venta){
                            $simcard->segundo_pago = true;
                        }
                        $fecha_venta = date('Ym', strtotime("+3 months", strtotime($simcard->fecha_venta)));
                        if($fecha_comision == $fecha_venta){
                            $simcard->tercer_pago = true;
                        }
                        $fecha_venta = date('Ym', strtotime("+6 months", strtotime($simcard->fecha_venta)));
                        if($fecha_comision == $fecha_venta){
                            $simcard->cuarto_pago = true;
                        }
                    }else{
                        $comision = new Comision();
                        $comision->valor = $row->valor;
                        $comision->fecha = $fecha;
                        $comision->Simcard_ICC = $simcard->ICC;   
                        $comision->save();
                    }
                    
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
                    $simcard->cliente_identificacion = $row->cliente_identificacion;
                    $simcard->save();
                    if($row->imei != null){
                        $equipo = Equipo::find($row->imei);
                        if($equipo != null){  
                            $equipo->simcard_ICC = $comision->Simcard_ICC;
                            $equipo->cliente_identificacion = $row->cliente_identificacion;
                            $equipo->save();
                        }
                    }
                }else{
                    $error = new Error();
                    $error->Notificacion_ID = $notificacion_ID;
                    $error->descripcion = $counter_filas . ": Simcard no encontrada";  
                    $error->save();
                    $filas_malas++;
                }
                
                $filas_buenas++;
            }catch(\Exception $e){
                $error = new Error();
                $error->Notificacion_ID = $notificacion_ID;
                $error->descripcion = $counter_filas . $e->getMessage();  
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
