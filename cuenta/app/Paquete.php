<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paquete extends Model
{
    protected $table = "paqapp";

    //protected $fillable = ['paqapp_nomapp','paqapp_cantrfc','paqapp_cantgig','paqapp_f_venta','paqapp_f_act','paqapp_f_fin','paqapp_f_caduc'];

    public function __construct()
    {
        $this->connection = \Session::get('selected_database','mysql');
    }
}
