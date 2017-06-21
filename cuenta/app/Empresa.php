<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = "empr";

    protected $fillable = ['empr_nom','empr_rfc','empr_razsoc','empr_logo','empr_marc_agua'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = \Session::get('selected_database','mysql');
    }

    public function basedatosapps(){

    	return $this->hasMany('App\BasedatosApp','bdapp_empr_id');
    }
}
