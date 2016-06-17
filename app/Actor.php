<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    protected $table = 'Actor';
    protected $primaryKey  = 'cedula';
    
    protected $fillable = ['cedula', 'nombre', 'correo', 'telefono', 'tipo_canal', 'contratante', 'tipo_contrato', 'sueldo', 'jefe_cedula'];

    public function paquetes()
    {
        return $this->hasMany('App\Paquete');
    }
}
