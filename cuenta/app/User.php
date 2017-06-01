<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Bican\Roles\Traits\HasRoleAndPermission;
use Bican\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;


class User extends Authenticatable implements HasRoleAndPermissionContract

{
    use Notifiable, HasRoleAndPermission;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','users_nick','users_tel','users_f_ultacces','users_activo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function basedatosapps(){

        return $this->belongsToMany('App\BasedatosApp');
    }

    public function bitacoras(){

        return $this->hasMany('App\Bitacora');
    }
}
