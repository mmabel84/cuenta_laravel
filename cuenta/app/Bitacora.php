<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    protected $table = "bitcta";
    protected $fillable = ['bitc_fecha','bitc_modulo','bitcta_ip','bitcta_naveg','bitcta_tipo_op','bitcta_msg','bitcta_result','bitcta_dato','bitcta_users_id'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = \Session::get('selected_database','mysql');
    }

    public function user(){

    	return $this->belongsTo('App\User','bitcta_users_id');
    }
}
