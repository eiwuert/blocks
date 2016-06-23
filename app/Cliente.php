<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'Cliente';
    protected $primaryKey = 'identificacion';
    public $timestamps = false;
    protected $fillable = ['identificacion', 'tipo','nombre','telefono','correo','direccion','Ubicacion_ID'];

    public function ubicacion(){
        return $this->hasOne('App\Ubicacion','ID','Ubicacion_ID');
    }
    
    public function responsable(){
        return $this->hasOne('App\Responsable_Empresa','Cliente_identificacion','identificacion');
    }
    
    public function simcards(){
        return $this->hasMany('App\Simcard','Cliente_identificacion','identificacion');
    }
    
    public function equipos(){
        return $this->hasMany('App\Equipo','Cliente_identificacion','identificacion');
    }
}
