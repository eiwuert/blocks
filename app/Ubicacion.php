<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    protected $table = 'Ubicacion';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    
    protected $fillable = ['ID', 'region', 'ciudad'];
    
    public function actor()
    {
        return $this->belongsTo('App\Actor', 'Ubicacion_ID','ID');
    }
}
