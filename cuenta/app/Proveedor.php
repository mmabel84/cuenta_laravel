<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = "prov";
    protected $fillable = ['prov_nom','prov_rfc'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = \Session::get('selected_database','mysql');
    }

    public function basedatosapps(){

    	return $this->belongsToMany('App\BasedatosApp');
    }
}
