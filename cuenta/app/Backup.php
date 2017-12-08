<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Backup extends Model
{
    protected $table = "backbd";
    protected $fillable = ['backbd_back','backbd_fecha','backbd_bdapp_id', 'backbd_linkback', 'backbd_user', 'backbd_coment'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = \Session::get('selected_database','mysql');
    }

    public function basedatosapp(){

    	return $this->belongsTo('App\BasedatosApp','backbd_bdapp_id');
    }
}
