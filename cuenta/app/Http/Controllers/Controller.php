<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;
use App\Bitacora;
use Illuminate\Http\Request;
use Sinergi\BrowserDetector\Browser;
use App\User;



class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function registroBitacora(Request $request, $fname='', $fmessage=''){
        if ($fname == 'login'){
            $user = User::where('email', '=', $request['email'])->get()[0];
        }
        else
        {
            $user = \Auth::user();
        }

        if (!$user->users_control)
        {
            $browser = new Browser();
            $split_var = explode('\Controllers',get_class($this));
            $bit = new Bitacora();
            $bit->bitcta_users_id = $user->id;
            $bit->bitcta_user = $user->name;
            $bit->bitc_fecha = date("Y-m-d H:i:s");
            $bit->bitcta_tipo_op = $fname;
            $bit->bitcta_ip = $request->ip();
            $bit->bitcta_naveg = $browser->getName().' '.$browser->getVersion();
            $bit->bitc_modulo = $split_var[1];
            $bit->bitcta_result = '';
            $bit->bitcta_msg = $fmessage;
            $bit->bitcta_dato = json_encode($request->all());

            $bit->save();
        }
        

        
    }

    public function getAccessToken($control_app='control'){

        $url_aux = config('app.advans_apps_url.'.$control_app);
        //Log::info(config('app.advans_apps_security.'.$control_app));
        //Log::info($url_aux);
        $http = new \GuzzleHttp\Client();
        $response = $http->post($url_aux.'/oauth/token', [
            'form_params' => config('app.advans_apps_security.'.$control_app),
        ]);
        

       $vartemp = json_decode((string) $response->getBody(), true);
       //Log::info($vartemp);
        return $vartemp;
    }


   public function getAppService($access_token,$app_service,$arrayparams,$control_app='control'){
        $http = new \GuzzleHttp\Client();

        $query = http_build_query($arrayparams);

       $url_aux = config('app.advans_apps_url.'.$control_app);
        $array_send = [
                       'headers' => [
                                    'Authorization' => 'Bearer '.$access_token,
                                    ]
                      ];
        $response = $http->get($url_aux.'/api/'.$app_service.'?'.$query, $array_send);

       return json_decode((string) $response->getBody(), true);
    }
}
