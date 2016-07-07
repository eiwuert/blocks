<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asignacion_Permiso extends Model
{
    protected $table = 'Asignacion_Permiso';
    protected $fillable = ['User_email','permiso'];
    public $timestamps = false;
    
    public function user(){
        return $this->belongsTo('App\User','User_email','email');
    }
}
