<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Bican\Roles\Traits\HasRoleAndPermission;
use Bican\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB; 
use Laravel\Passport\HasApiTokens;
use App\Notifications\MyResetPassword;
use Illuminate\Database\Eloquent\Model;


class User extends Authenticatable implements HasRoleAndPermissionContract

{
    use Notifiable, HasRoleAndPermission, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','users_nick','users_tel','users_f_ultacces','users_activo', 'users_pic'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = \Session::get('selected_database','mysql');
    }
    
    public function basedatosapps(){

        return $this->belongsToMany('App\BasedatosApp','bdusr','bdusr_bdusr_id','bdusr_bdapp_id');
    }

    public function bitacoras(){

        return $this->hasMany('App\Bitacora');
    }

    

    /**
     *
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function customGetUserPerms($perm_id,$count=false)
    {
        $dbname = \Session::get('selected_database','mysql');
        if($count!=false)
        {
            $perms = DB::connection($dbname)->table('permission_user')->where([
                ['permission_id', '=', $perm_id],
                ['user_id', '=', $this->id],
            ])->count();
        }
        else
        {
            $perms = DB::connection($dbname)->table('permission_user')->where([
                ['permission_id', '=', $perm_id],
                ['user_id', '=', $this->id],
            ])->get();
        }
        return $perms;
    }


    /**
     *
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function customPermsByUser($count=false)
    {
        $dbname = \Session::get('selected_database','mysql');
        if($count!=false){
            $perms = DB::connection($dbname)->table('permission_user')->where('user_id', '=', $this->id)->count();
        }else{
            $perms = DB::connection($dbname)->table('permission_user')->where('user_id', '=', $this->id)->get();
        }
        return $perms;
    }


    /**
     *
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function customGetRolePerms($role_id,$perm_id,$count=false)
    {
        $dbname = \Session::get('selected_database','mysql');

        if($count!=false){
            $perms = DB::connection($dbname)->table('permission_role')->where([
                ['permission_id', '=', $perm_id],
                ['role_id', '=', $role_id],
            ])->count();
        }else{
            $perms = DB::connection($dbname)->table('permission_role')->where([
                ['permission_id', '=', $perm_id],
                ['role_id', '=', $role_id],
            ])->get();
        }
        return $perms;
    }


    /**
     *
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function customRolesByUser($count=false)
    {
        $dbname = \Session::get('selected_database','mysql');
        if($count!=false){
            $perms = DB::connection($dbname)->table('role_user')->where('user_id', '=', $this->id)->count();
        }else{
          $perms = DB::connection($dbname)->table('role_user')->where('user_id', '=', $this->id)->get();
        }
        return $perms;
    } 

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MyResetPassword($token));
    }
}
