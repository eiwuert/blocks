<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Simcard extends Model
{
    protected $table = 'Simcard';
    protected $primaryKey = 'ICC';
    public $timestamps = false;
    
    protected $fillable = ['ICC', 'numero_linea', 'categoria', 'contratante','fecha_vencimiento', 'fecha_adjudicacion', 'fecha_asignacion', 'fecha_activacion', 'Paquete_ID','Cliente_identificacion','fecha_venta'];

    public function paquete()
    {
        return $this->belongsTo('App\Paquete','Paquete_ID','ID');
    }
    
    public function cliente()
    {
        return $this->belongsTo('App\Cliente','Cliente_identificacion','identificacion');
    }
    public function equipo()
    {
        return $this->belongsTo('App\Equipo','ICC','Simcard_ICC');
    }
    public function plan(){
        return $this->hasOne('App\Asignacion_Plan','Simcard_ICC','ICC');
    }
    
    public function comisiones()
    {
        return $this->hasMany('App\Comision', "Simcard_ICC", 'ICC');
    }
    
    public static function color_estado($simcard){
        $color ="";
        $hoy = new DateTime();
        $fecha_vencimiento = new DateTime($simcard->fecha_vencimiento);
        if($simcard->categoria != "Postpago"){
            if($simcard->fecha_activacion != null){
                $fecha_activacion = new DateTime($simcard->fecha_activacion);    
                $interval = $hoy->diff($fecha_activacion);
                $meses = ($interval->format("%y")*12)+($interval->format("%m"));
                if($meses > 6){
                    $color = "rojo";
                }else{
                    $color = "verde";
                }
            }else{
                $interval = $hoy->diff($fecha_vencimiento);
                $dias = $interval->format("%d");
                if($dias < 0){
                    $color = "rojo";
                }else{
                    $color = "azul";
                }
            }
        }else{
            if($simcard->numero_linea != null){
                $color = "verde"; 
            }else{
                $color = "azul"; 
            }
        }
        return $color;
    }
}
