<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asignacion_Plan extends Model
{
    protected $table = 'Asignacion_Plan';
    protected $primaryKey  = 'ID';
    protected $fillable = ['ID','Plan_codigo','Simcard_ICC'];
    public $timestamps = false;
    public function simcard(){
        return $this->belongsTo('App\Simcard','Simcard_ICC','ICC');
    }
    public function plan(){
        return $this->belongsTo('App\Plan','Plan_codigo','codigo');
    }
}
