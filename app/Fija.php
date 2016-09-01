<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fija extends Model
{
    protected $table = 'Fija';
    protected $primaryKey = 'peticion';
    public $timestamps = false;
    protected $fillable = ['peticion','Actor_cedula','linea_base','internet','tv' 'Cliente_identificacion','fecha_venta'];

    
    public function cliente(){
        return $this->hasOne('App\Cliente','identificacion','Cliente_identificacion');
    }
    
    public function responsable(){
        return $this->belongsTo('App\Actor','Actor_cedula','cedula');
    }
}
