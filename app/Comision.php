<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comision extends Model
{
    protected $table = 'Comision';
    protected $primaryKey  = 'ID';
    protected $fillable = ['ID','fecha','valor','Simcard_ICC','Equipo_IMEI', 'Servicio_peticion'];
    public $timestamps = false;
    
    public function simcard(){
        return $this->belongsTo('App\Simcard','Simcard_ICC','ICC');
    }
    
    public function equipo(){
        return $this->belongsTo('App\Equipo','Equipo_IMEI','IMEI');
    }
    
    public function servicio(){
        return $this->belongsTo('App\Servicio','Servicio_peticion','peticion');
    }
    
}
