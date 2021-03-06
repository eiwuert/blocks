<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    protected $table = 'users';
    protected $primaryKey = 'email';
    
    protected $fillable = ['Actor_cedula', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];
    
    public function actor()
    {
        return $this->belongsTo('App\Actor','Actor_cedula','cedula');
    }
    
    public function permisos()
    {
        return $this->hasMany('App\Asignacion_Permiso','User_email','email');
    }
    
}
