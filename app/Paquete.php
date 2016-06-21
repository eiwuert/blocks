<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paquete extends Model
{
    protected $table = 'Paquete';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    
    protected $fillable = ['ID','Actor_cedula', 'fecha_entrega'];

    public function actor(){
        return $this->belongsTo('App\Actor','Actor_cedula','cedula');
    }
    
    public function simcards()
    {
        return $this->hasMany('App\Simcard');
    }
}
