<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'Plan';
    protected $primaryKey = 'codigo';
    public $timestamps = false;
    protected $fillable = ['codigo','cantidad_minutos', 'cantidad_datos','valor','descripcion'];

    public function asignacion(){
        return $this->hasOne('App\Asignacion_Plan','codido','Plan_codigo');
    }
}
