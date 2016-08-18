<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'Notificacion';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = ['ID','Actor_cedula', 'descripcion','exito', 'resultado'];

}
