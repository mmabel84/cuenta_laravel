<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Backup extends Model
{
    protected $table = "backbd";
    protected $fillable = ['backbd_back','backbd_fecha','backbd_bdapp_id'];

    public function basedatosapp(){

    	return $this->belongsTo('App\BasedatosApp','backbd_bdapp_id');
    }
}
