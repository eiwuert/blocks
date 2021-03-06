<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $table = 'Equipo';
    protected $primaryKey = 'IMEI';
    public $timestamps = false;
    protected $fillable = ['IMEI','Actor_cedula','Simcard_ICC', 'Cliente_identificacion','fecha_venta','Descripcion_Equipo_cod_scl','descripcion_precio','fecha_asignacion'];

    
    public function cliente(){
        return $this->hasOne('App\Cliente','identificacion','Cliente_identificacion');
    }
    public function simcard(){
        return $this->hasOne('App\Simcard','ICC','Simcard_ICC');
    }
    public function descripcion_equipo(){
        return $this->hasOne('App\Descripcion_Equipo','cod_scl','Descripcion_Equipo_cod_scl');
    }
    public function responsable(){
        return $this->belongsTo('App\Actor','Actor_cedula','cedula');
    }
}
