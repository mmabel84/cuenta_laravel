<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aplicacion extends Model
{
    protected $table = "app";

    protected $fillable = ['app_nom','app_cod'];

    public function basedatosapps(){

    	return $this->hasMany('App\BasedatosApp','bdapp_app_id');
    }

}
