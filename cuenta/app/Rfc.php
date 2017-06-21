<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rfc extends Model
{
    protected $table = "rfc";
    protected $fillable = ['rfc_nom','rfc_num','rfc_razsoc','rfc_logo'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = \Session::get('selected_database','mysql');
    }

    public function basedatosapps(){

    	return $this->belongsToMany('App\BasedatosApp');
    }
}
