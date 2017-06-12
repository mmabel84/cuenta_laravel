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
        $bit = new Bitacora(['bitcta_users_id'=>$user->id,'bitc_fecha'=>date("Y-m-d H:i:s"),'bitcta_tipo_op'=>$fname,'bitcta_ip'=>$request->ip(),'bitcta_naveg'=>$browser->getName().' '.$browser->getVersion(),'bitc_modulo'=>$split_var[1],'bitcta_result'=>'TODO','bitcta_msg'=>$fmessage,'bitcta_dato'=>json_encode($request->all())]);
        $bit->save();
    }
}
