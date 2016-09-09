<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'Venta';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    
    protected $fillable = ['ID','Actor_cedula', 'fecha_legalizacion', 'valor'];

    public function actor(){
        return $this->belongsTo('App\Actor','Actor_cedula','cedula');
    }

}
