<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comision extends Model
{
    protected $table = 'Comision';
    protected $primaryKey  = 'ID';
    protected $fillable = ['ID','fecha','Simcard_ICC','valor'];
    public $timestamps = false;
    
    public function simcard(){
        return $this->belongsTo('App\Simcard','Simcard_ICC','ICC');
    }
    
}
