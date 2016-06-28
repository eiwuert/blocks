<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ubicacion_Empleado extends Model
{
    protected $table = 'Ubicacion_Empleado';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    
    protected $fillable = ['ID', 'fecha', 'latitud', 'longitud', 'Actor_cedula'];
    
    public function actor()
    {
        return $this->belongsTo('App\Actor', 'cedula','Actor_cedula');
    }
}
