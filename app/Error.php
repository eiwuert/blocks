<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Error extends Model
{
    protected $table = 'Error';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = ['ID','descripcion', 'Notificacion_ID'];
    
    public function notificacion(){
        return $this->hasOne('App\Notificacion','ID','Notificacion_ID');
    }
}
