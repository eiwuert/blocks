<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fija extends Model
{
    protected $table = 'Fija';
    protected $primaryKey = 'peticion';
    public $timestamps = false;
    protected $fillable = ['peticion','tipo_producto', 'nombre_producto','Actor_cedula', 'Cliente_identificacion','fecha_venta'];

    
    public function cliente(){
        return $this->hasOne('App\Cliente','identificacion','Cliente_identificacion');
    }
    
    public function responsable(){
        return $this->belongsTo('App\Actor','Actor_cedula','cedula');
    }
}
