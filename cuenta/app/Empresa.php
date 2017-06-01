<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = "empr";

    protected $fillable = ['empr_nom','empr_rfc','empr_razsoc','empr_logo','empr_marc_agua'];

    public function basedatosapps(){

    	return $this->hasMany('App\BasedatosApp');
    }
}
