<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BasedatosApp extends Model
{
    protected $table = "bdapp";
    protected $fillable = ['bdapp_app_id','bdapp_nombd','bdapp_nomserv','bdapp_empr_id'];

    public function empresa(){

    	return $this->belongsTo('App\Empresa','bdapp_empr_id');
    }

    public function aplicacion(){

        return $this->belongsTo('App\Aplicacion','bdapp_app_id');
    }

    public function backups(){

    	return $this->hasMany('App\Backup','backbd_bdapp_id');
    }

    public function proveedores(){

    	return $this->belongsToMany('App\Proveedor','bdprov','bdprov_bdapp_id','bdprov_prov_id');
    }

    public function rfcs(){

    	return $this->belongsToMany('App\Rfc','bdrfc','bdrfc_bdapp_id','bdrfc_rfc_id');
    }

    public function users(){

    	return $this->belongsToMany('App\User','bdusr','bdusr_bdapp_id','bdusr_bdusr_id');
    }
}
