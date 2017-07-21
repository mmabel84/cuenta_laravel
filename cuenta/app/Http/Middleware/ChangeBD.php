<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\Controller;

class ChangeBD
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
       //TODO Uncomment for multiple BD Con
        $alldata = $request->all();
        $midred = $request->session()->exists('midred');
        if(!$midred){
            if(array_key_exists('login_rfc',$alldata)){
                $dbvalue = config('database.connections');
                $rfc = strtoupper($alldata['login_rfc']);
                $dbname = $rfc.'_cta';
                if(array_key_exists($dbname,$dbvalue)){

                    //Consumir servicio de control para verificar que la cuenta está activa
                    $cont = new Controller;
                    $acces_vars = $cont->getAccessToken();
                    $arrayparams['rfc'] = $alldata['login_rfc'];
                    try
                    {
                        $service_response = $cont->getAppService($acces_vars['access_token'],'getaccstate',$arrayparams,'control');
                    } 
                    catch (\GuzzleHttp\Exception\ServerException $e) 
                    {
                         $request->session()->put('loginrfcerr', 'Sin comunicación a servicio de control');
                    }
                    
                    if ($service_response['accstate'] == 'Activa'){

                        \Session::put('selected_database',$dbname);
                        \Config::set('database.default', $dbname);
                        $request->session()->pull('loginrfcerr');
                        
                    }else{
                        $request->session()->flash('midred', '1');
                        $request->session()->put('loginrfcerr', 'Cuenta bloqueada');
                        $request->session()->put('login_rfc', $dbname);  

                        $bitcta_msg = 'Intento de login fallido por cuenta bloqueada desde control';
                        $bitc_fecha = date("Y-m-d H:i:s");
                        $bitcta_tipo_op = 'Failed login';
                        $bitc_modulo = '\Login';
                        $bitcta_dato = json_encode($_REQUEST);
                        $advans_usr = DB::connection($dbname)->select('select id, name, email from users where users_control = true');
                        $bitcta_users_id = null;
                        if (count($advans_usr) > 0)
                        {
                            $bitcta_users_id = $advans_usr[0]->id;
                        }
                        DB::connection($dbname)->insert('insert into bitcta (bitc_fecha, bitc_modulo, bitcta_tipo_op, bitcta_msg, bitcta_users_id, bitcta_dato,  created_at) values (?, ?, ?, ?, ?, ?, ?)', [$bitc_fecha, $bitc_modulo, $bitcta_tipo_op, $bitcta_msg, $bitcta_users_id, $bitcta_dato, date('Y-m-d H:i:s')]);    

                        return redirect()->back();
                    }
                }else{
                    $request->session()->flash('midred', '1');
                    $request->session()->put('loginrfcerr', 'RFC no registrado');
                    $request->session()->put('login_rfc', $dbname);                  
                    return redirect()->back();
                }
             }
         }

       return $next($request);
    }
}
