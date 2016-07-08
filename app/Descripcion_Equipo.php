<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Descripcion_Equipo extends Model
{
    protected $table = 'Descripcion_Equipo';
    protected $primaryKey = 'cod_scl';
    public $timestamps = false;
    protected $fillable = ['cod_scl','tecnologia','modelo','precio_prepago','precio_contado','precio_3_cuotas','precio_6_cuotas','precio_12_cuotas','precio_24_cuotas'];

    
    public function equipos(){
        return $this->hasMany('App\Equipo','Descripcion_Equipo_cod_scl','cod_scl');
    }
}
