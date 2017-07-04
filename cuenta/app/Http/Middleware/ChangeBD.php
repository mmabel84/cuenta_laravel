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
                $dbname = $alldata['login_rfc'].'_cta';
                if(array_key_exists($dbname,$dbvalue)){

                    //Consumir servicio de control para verificar que la cuenta está activa
                    $cont = new Controller;
                    $acces_vars = $cont->getAccessToken();
                    $arrayparams['rfc'] = $alldata['login_rfc'];
                    try
                    {
                        $service_response = $cont->getAppService($acces_vars['access_token'],'getaccstate',$arrayparams,'control');
                    } 
                    catch (Exception $e) 
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
                        return redirect('/');

                    }

                    
                }else{
                    $request->session()->flash('midred', '1');
                    $request->session()->put('loginrfcerr', 'RFC Inválido');
                    $request->session()->put('login_rfc', $dbname);                  
                   return redirect('/');
                }
             }
         }

       return $next($request);
    }
}
