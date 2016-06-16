<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Simcard extends Model
{
    protected $table = 'Simcard';
    protected $primaryKey = 'ICC';
    
    protected $fillable = ['ICC', 'numero_linea', 'categoria', 'fecha_adjudicacion', 'fecha_asignacion', 'fecha_activacion', 'fecha_entrega', 'Cliente_ID', 'Actor_cedula'];

}
