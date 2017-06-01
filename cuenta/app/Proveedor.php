<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = "prov";
    protected $fillable = ['prov_nom','prov_rfc'];

    public function basedatosapps(){

    	return $this->belongsToMany('App\BasedatosApp');
    }
}
