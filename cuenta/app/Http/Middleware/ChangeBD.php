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
                if(array_key_exists($alldata['login_rfc'],$dbvalue)){

                    //Consumir servicio de control para verificar que la cuenta está activa
                    /*$cont = new Controller;
                    $acces_vars = $cont->getAccessToken();
                    $arrayparams['rfc'] = $alldata['login_rfc'];
                    try
                    {
                        $service_response = $cont->getAppService($acces_vars['access_token'],'getaccstate',$arrayparams,'control');
                    } 
                    catch (Exception $e) 
                    {
                         $request->session()->put('loginrfcerr', 'Credenciales de conexión inválidas');
                    }
                    

        
                    if ($service_response['accstate'] == 'Activa'){*/
                    if (true){

                        \Session::put('selected_database',$alldata['login_rfc']);
                        \Config::set('database.default', $alldata['login_rfc']);
                        $request->session()->pull('loginrfcerr');
                        //$request->session()->pull('login_rfc');
                        //$fmessage = 'Se ha autenticado el usuario: '.$alldata['email'];
                        //$cont->registroBitacora($request,'login',$fmessage);
                        
                    }else{
                        $request->session()->flash('midred', '1');
                        $request->session()->put('loginrfcerr', 'Cuenta bloqueada');
                        $request->session()->put('login_rfc', $alldata['login_rfc']);                  
                        return redirect('/');

                    }

                    
                }else{
                    $request->session()->flash('midred', '1');
                    $request->session()->put('loginrfcerr', 'RFC Inválido');
                    $request->session()->put('login_rfc', $alldata['login_rfc']);                  
                   return redirect('/');
                }
             }
         }

       return $next($request);
    }
}
