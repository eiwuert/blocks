<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Simcard extends Model
{
    protected $table = 'Simcard';
    protected $primaryKey = 'ICC';
    public $timestamps = false;
    
    protected $fillable = ['ICC', 'numero_linea', 'categoria', 'fecha_adjudicacion', 'fecha_asignacion', 'fecha_activacion', 'Paquete_ID'];

    public function paquete()
    {
        return $this->belongsTo('App\Paquete','Paquete_ID','ID');
    }
}
