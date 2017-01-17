<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TablaComision extends Model
{
    protected $table = 'Tabla_comisiones';
    protected $primaryKey = 'tipo';
    public $timestamps = false;
    
    protected $fillable = ['tipo', 'tipoPersona', 'descripcion', 'valor', 'orden'];

}
