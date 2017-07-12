<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Aplicacion;
use App\Paquete;
use App\User;
use Illuminate\Support\Facades\Log;
use App\Bitacora;
use App\BasedatosApp;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class ServAppController extends Controller
{
    
    public function createappdb(Request $request, $appcod)
    {
        $account = false;
        $alldata = $request->all();
        $return_array = array();
        

        $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVXWYZ0123456789!"$%&/()=?¿*/[]{}.,;:';
        $password = $this->rand_chars($caracteres,8);
        $resultm = preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&#.$($)$-$_])[a-zA-Z\d$@$!%*?&#.$($‌​)$-$_]{8,50}$/u', $password, $matchesm);

        while(!$resultm || count($matchesm) == 0){
            $password = $this->rand_chars($caracteres,8);
            $resultm = preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&#.$($)$-$_])[a-zA-Z\d$@$!%*?&#.$($‌​)$-$_]{8,50}$/u', $password, $matchesm);
        }

        $cliente_correo = $account->client ? $account->client->cliente_correo : false;
        if ($cliente_correo){
            $aaa = 1;
            //TODO Descomentar cuando se desbloquee el puerto 587
            //Mail::to($cliente_correo)->send(new ClientCreate(['user'=>$cliente_correo,'password'=>$password]));
        }
        
        $arrayparams['rfc_nombrebd'] = $account->cta_num ? $account->cta_num : '';
        $arrayparams['empr_rfc'] = $account->client ? $account->client->cliente_rfc : '';
        $arrayparams['empr_email'] = $account->client ? $account->client->cliente_correo : '';
        $arrayparams['empr_name'] = $account->client ? $account->client->cliente_nom : '';
        $arrayparams['password'] = $password;
        $arrayparams['empr_nick'] = count(explode('@',$arrayparams['client_email'])) > 1 ? explode('@',$arrayparams['client_email'])[0] : '';
        $arrayparams['account_id'] = $account->id;

        $acces_vars = $this->getAccessToken($appcod);
        $service_response = $this->getAppService($acces_vars['access_token'],'createbd',$arrayparams,$appcod);
        $fmessage = 'Se ha generado la base de datos de aplicación: '. .' de '.;
        $this->registroBitacora($request,'create',$fmessage); 
        \Session::flash('message',$fmessage);

        
        $response = array(
            'status' => 'success',
            'msg' => 'Se generó satisfactoriamente la base de datos de aplicación',
        );
        return \Response::json($response);
    } 
}
