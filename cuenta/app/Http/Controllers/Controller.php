<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Bitacora;
use Illuminate\Http\Request;
use Sinergi\BrowserDetector\Browser;



class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function registroBitacora(Request $request, $fname='', $fmessage=''){
        $user = \Auth::user();

        $browser = new Browser();
        $split_var = explode('\Controllers',get_class($this));
        $bit = new Bitacora();
        $bit->bitcta_users_id = $user->id;
        $bit->bitc_fecha = date("Y-m-d H:i:s");
        $bit->bitcta_tipo_op = $fname;
        $bit->bitcta_ip = $request->ip();
        $bit->bitcta_naveg = $browser->getName().' '.$browser->getVersion();
        $bit->bitc_modulo = $split_var[1];
        $bit->bitcta_result = 'TODO';
        $bit->bitcta_msg = $fmessage;
        $bit->bitcta_dato = json_encode($request->all());


        $bit->save();
    }
}
