<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    protected $table = 'Actor';
    protected $primaryKey  = 'cedula';
    public $timestamps = false;
    
    protected $fillable = ['cedula', 'nombre', 'correo', 'telefono', 'tipo_canal', 'contratante', 'tipo_contrato', 'sueldo', 'jefe_cedula','porcentaje_equipo','porcentaje_servicio','porcentaje_prepago','porcentaje_libre','porcentaje_postpago'];

    public function paquetes()
    {
        return $this->hasMany('App\Paquete');
    }
}
