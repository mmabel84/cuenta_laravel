<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aplicacion extends Model
{
    protected $table = "app";

    protected $fillable = ['app_nom','app_cod'];

    public function __construct()
    {
        $this->connection = \Session::get('selected_database','mysql');
    }

    public function basedatosapps(){

    	return $this->hasMany('App\BasedatosApp','bdapp_app_id');
    }

}
