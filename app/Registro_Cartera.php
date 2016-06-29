<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registro_Cartera extends Model
{
    protected $table = 'Registro_Cartera';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    
    protected $fillable = ['ID', 'fecha', 'valor_unitario', 'cantidad','descripcion', 'Actor_cedula'];
    
    public function actor()
    {
        return $this->belongsTo('App\Actor', 'cedula','Actor_cedula');
    }
}
