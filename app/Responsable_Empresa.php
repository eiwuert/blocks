<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Responsable_Empresa extends Model
{
    protected $table = 'Responsable_Empresa';
    protected $primaryKey = 'cedula';
    public $timestamps = false;
    protected $fillable = ['cedula', 'nombre','telefono','correo','Cliente_identificacion'];

    public function cliente(){
        return $this->belongsTo('App\Cliente','Cliente_identificacion','identificacion');
    }
}
