<?php

namespace App\Http\Controllers;

use App\BasedatosApp;
use App\User;
use App\Empresa;
use App\Aplicacion;
use Illuminate\Http\Request;
use View;
use Illuminate\Support\Facades\Redirect;
use App\Bitacora;
use App\Mail\InstEmail;
use Illuminate\Support\Facades\Log;

class AppController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

     public function index()
    {       
        $usr = $user = \Auth::user();
        if ($usr->can('leer.aplicacion'))
        {
            //$usrs = User::all();
            $usrs = User::where('users_control','<>',true)->get();
            $apps = BasedatosApp::all();

            foreach ($apps as $app) {
                if ($app->aplicacion->app_estado == 'Prueba'){
                    $app->uso = 'Prueba';
                }
                else
                {
                    $app->uso = 'Producción';
                }
            }
            return view('apps',['apps'=>$apps,'usrs'=>$usrs]);
        }
        \Session::flash('failmessage','No tiene acceso a leer aplicaciones');
        return redirect()->back();
    }

    public function indexprueba()
    {   
        $usr = $user = \Auth::user();
        if ($usr->can('leer.aplicacion'))
        {    
            $apps = BasedatosApp::all();
            $usrs = User::all();
            $apps_prueba = [];

            foreach ($apps as $app ) {
                
                    if ($app->aplicacion->app_estado == 'Prueba')
                    {
                         array_push($apps_prueba, $app);
                    }
                }

            return view('apps',['apps'=>$apps_prueba,'usrs'=>$usrs]);
        }
        \Session::flash('failmessage','No tiene acceso a leer aplicaciones');
        return redirect()->back();     
        
    }

    public function create()
    {       
        $usr = $user = \Auth::user();
        if ($usr->can('crear.aplicacion'))
        {
            $empresa = Empresa::all();
            $aplicaciones = Aplicacion::all();
            return view('appcreate',['empresas'=>$empresa,'aplicaciones'=>$aplicaciones]);

        }
        
        \Session::flash('failmessage','No tiene acceso a crear aplicaciones');
        return redirect()->back();
    }

    public function rand_chars($characters,$length)
    {
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;

    }

    public function store(Request $request)
    {
        $bdapps = BasedatosApp::all();
    	$emprexist = null;
        $appexist = null;
        $empresa = Empresa::find($request->bdapp_empr_id);
        $app = Aplicacion::find($request->bdapp_app_id);
        $exist = 0;
        $gener_inst = config('app.advans_apps_gener_inst.'.$app->app_cod);

    	foreach ($bdapps as $a )
    	{
    		if ($a->bdapp_app_id == $request->bdapp_app_id && $a->bdapp_empr_id == $request->bdapp_empr_id)
    		{
                $exist = 1;
    		}
    	}
    	
    	if ($exist == 1)
    	{
	    	\Session::flash('failmessage','Ya existe la aplicación '.$app->app_nom. ' de empresa '.$empresa->empr_nom);
	    	return redirect()->back();
    	}

    	$appbd = new BasedatosApp;
        $dbs = BasedatosApp::where('bdapp_app', '=', $app->app_cod)->get();
        $fmessage = 'No se puede generar la solución '.$app->app_nom." de la empresa ".$empresa->empr_nom.' pues ha alcanzado el límite máximo de soluciones contratadas';
        $instlimit = $app->app_insts;
       
        if ($instlimit == null || count($dbs) <  $instlimit)
        {
            $appbd->bdapp_app_id = $app->id;
            $appbd->bdapp_app = $app->app_cod;
            $appbd->bdapp_empr_id = $empresa->id;
            //TODO llamar archivo de configuracion para seleccionar base de datos
            $appbd->bdapp_nomserv = '';
            $appbd->bdapp_nombd = '';
            $user = \Auth::user();
            
            //Si aplicación genera instancia, se ejecuta servicio web para crear base de datos
             if ($app->app_cod != 'fact')
             {
                //Llamar a servicio web que genera base de datos en aplicación
                $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVXWYZ0123456789!"$%&/()=?¿*/[]{}.,;:';
                $password = $this->rand_chars($caracteres,8);
                $resultm = preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&#.$($)$-$_])[a-zA-Z\d$@$!%*?&#.$($‌​)$-$_]{8,50}$/u', $password, $matchesm);

                while(!$resultm || count($matchesm) == 0){
                    $password = $this->rand_chars($caracteres,8);
                    $resultm = preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&#.$($)$-$_])[a-zA-Z\d$@$!%*?&#.$($‌​)$-$_]{8,50}$/u', $password, $matchesm);
                }

                $empresaprincipal = Empresa::where('empr_principal', '=', true)->get();
                $emprrfc = $empresa->empr_rfc;
                $ctarfc = $emprrfc; 
                if (count($empresaprincipal) > 0)
                {
                    $ctarfc = $empresaprincipal[0]->empr_rfc;
                }

                $appbd->bdapp_nombd =  $ctarfc.'_'.$emprrfc.'_'.$app->app_cod;
                
                $user_email = $user->email;
                $arrayparams['email'] = $user_email;
                $arrayparams['name'] = $user->name;
                $arrayparams['id_cuenta'] = $user->id;
                $arrayparams['password'] = $password;
                $arrayparams['rfc'] = $emprrfc;
                $arrayparams['cta'] = $ctarfc;
                $arrayparams['dbname'] = $ctarfc.'_'.$emprrfc.'_'.$app->app_cod;
                //$url_inst = config('app.advans_apps_url.'.$app->app_cod).'/loginservice'.'/'.$ctarfc.'/'.$emprrfc;
                $url_inst = config('app.advans_apps_url.'.$app->app_cod).'/login';
                

                $acces_vars = $this->getAccessToken($app->app_cod);
                $service_response = $this->getAppService($acces_vars['access_token'],'createbd',$arrayparams,$app->app_cod);
                
                /*echo '<pre>';
                print_r(json_decode($service_response['dbvalue']));
                print_r(json_decode($service_response['dbvalueafter']));
                echo '</pre>';
                die();*/

                if ($user_email){
                    \Mail::to($user_email)->send(new InstEmail(['app'=>$app->app_nom,'empr'=>$empresa->empr_nom,'ctarfc'=>$ctarfc,'emprrfc'=>$emprrfc,'user'=>$user_email,'password'=>$password,'url'=>$url_inst]));
                }
                $appbd->save();
                $appbd->users()->attach($user->id);
             }
             else
             {
                $appbd->save();
             }
            

            $fmessage = 'Se ha generado la solución '.$app->app_nom." de la empresa ".$empresa->empr_nom;
            $this->registroBitacora($request,'create',$fmessage); 
            \Session::flash('message',$fmessage);
            return Redirect::to('apps');
        }
        \Session::flash('failmessage',$fmessage);
        return redirect()->back();

    }

     public function destroy($id, Request $request)
    {
        $appd = BasedatosApp::find($id);
        $arrayparams['dbname'] = $appd->bdapp_nombd;

        $gener_inst = config('app.advans_apps_gener_inst.'.$appd->bdapp_app);

        if ($appd->bdapp_app != 'fact')
        {
            $acces_vars = $this->getAccessToken($appd->bdapp_app);
            $service_response = $this->getAppService($acces_vars['access_token'],'dropbd',$arrayparams,$appd->bdapp_app);

            if ($service_response['status'] == 1)
            {
                
                $fmessage = 'Se ha eliminado la solución de aplicación '.$appd->aplicacion->app_nom.' de empresa '.$appd->empresa->empr_nom;

            }
            else
            {
               $fmessage = 'Solución de aplicación '.$appd->aplicacion->app_nom.' de empresa '.$appd->empresa->empr_nom.' no encontrada. Eliminada de cuenta';
            }

        }
        else
        {
            $fmessage = 'Se ha eliminado la solución de aplicación '.$appd->aplicacion->app_nom.' de empresa '.$appd->empresa->empr_nom.' de cuenta';
        }

        
        $appd->users()->detach();
        $appd-> backups()->delete();
        $appd->delete();
        $this->registroBitacora($request,'delete',$fmessage); 

        \Session::flash('message',$fmessage);

        return Redirect::to('apps');
    }


    public function edit($id)
    {       

        return redirect()->back();
       
    }


    public function relateAppUsr(Request $request)
    {
        $alldata = $request->all();

        if(array_key_exists('usrid',$alldata) && isset($alldata['usrid']) && array_key_exists('bdid',$alldata) && isset($alldata['bdid'])){
            if ($alldata['usrid'] == 'null')
            {
                $response = array ('status' => 'Failure', 'result' => "<label  style=' color:#790D4E' class='control-label col-md-12 col-sm-12 col-xs-12'>Debe seleccionar un usuario</label>");
                return \Response::json($response);
            }
            $usrp = User::find($alldata['usrid']);
            $bdp = BasedatosApp::find($alldata['bdid']);
            $exist = False;
            if($bdp && $usrp){
                $gener_inst = config('app.advans_apps_gener_inst.'.$bdp->bdapp_app);
                if ($bdp->bdapp_app != 'fact')
                {
                    $usrrelated = $bdp->users()->get();
                    foreach ($usrrelated as $u) {
                        if ($u->id == $alldata['usrid']){
                            $exist = True;
                        }
                    }

                    if ($exist == True)
                    {
                        $response = array ('status' => 'Failure', 'result' => "<label  style=' color:#790D4E' class='control-label col-md-12 col-sm-12 col-xs-12'>Ya existe la relación con el usuario ".$usrp->name."</label>");
                    }
                    else
                    {
                        if ($usrp->users_tel == null)
                        {
                            $tel = '';
                        }
                        else
                        {
                            $tel = $usrp->users_tel;
                        }

                         $usrarray = array('name'=>$usrp->name,'email'=>$usrp->email,'users_tel'=>$tel,'id_cuenta'=>$usrp->id);
                         
                         $app_cod = $bdp->bdapp_app;
                         $arrayparams['usr'] = $usrarray;
                         $arrayparams['dbname'] = $bdp->bdapp_nombd;
                         $arrayparams['roles'] = $alldata['roles'];
                         //Log::info($alldata['roles']);

                         $acces_vars = $this->getAccessToken($app_cod);
                         $service_response = $this->getAppService($acces_vars['access_token'],'adduser',$arrayparams,$app_cod);
                         $bdp->users()->attach($alldata['usrid']);

                        $btn = '<div 
                        class="btn-group'.$usrp->id.$bdp->id.'">
                        <a id="desvusrbtn'.$usrp->id.$bdp->id.'" onclick="unrelatedb('.$usrp->id.', '.$bdp->id.');" class="btn btn-xs" data-placement="left" title="Desasociar usuario" style=" color:#053666; background-color:#FFFFFF;"><i class="fa fa-close fa-3x"></i> </a></div>';
                         $response = array ('status' => 'Success', 'roles'=> $alldata['roles'], 'result' => '<tr id="row'.$usrp->id.$bdp->id.'">
                                         <td>' . $usrp->name . '</td>' .
                                        '<td>' . $usrp->email . '</td>' .
                                        '<td>' . $usrp->users_tel . '</td>' .

                                        '<td>' . $btn . '</td>' .

                                        '</tr>');
                        Log::info('row id al crear'.$usrp->id.$bdp->id);

                    }
                }
                else
                {   
                    $response = array ('status' => 'Failure', 'result' => "<label  style=' color:#790D4E' class='control-label col-md-12 col-sm-12 col-xs-12'>No aplica la acción de agregar usuario</label>");
                }
            }
            else
            {
                $response = array ('status' => 'Failure', 'result' => "<label  style=' color:#790D4E' class='control-label col-md-12 col-sm-12 col-xs-12'>Solución o usuario no encontrados</label>");
            }
            
        }
        else
        {

            $response = array ('status' => 'Failure', 'result' => "<label  style=' color:#790D4E' class='control-label col-md-12 col-sm-12 col-xs-12'>Usuario o solución no encontrados</label>");
        }
       
        return \Response::json($response);
    }


    public function unrelateAppUsr(Request $request)
    {
        $alldata = $request->all();
        $status = 'failure';
        $msg = '';

        if(array_key_exists('usrid',$alldata) && isset($alldata['usrid']) && array_key_exists('bdid',$alldata) && isset($alldata['bdid']))
        {
            $usrp = User::find($alldata['usrid']);
            $bdp = BasedatosApp::find($alldata['bdid']);
            if ($bdp && $usrp)
            {
                $dbname = $bdp->bdapp_nombd;

                $app_cod = $bdp->bdapp_app;

                $arrayparams['id_cuenta'] = $usrp->id;
                $arrayparams['dbname'] = $dbname;

                $acces_vars = $this->getAccessToken($app_cod);
                $service_response = $this->getAppService($acces_vars['access_token'],'dropuser',$arrayparams,$app_cod);
                $msgserv = $service_response['msg'];

                $msg = "<label  style=' color:#790D4E' class='control-label col-md-12 col-sm-12 col-xs-12'> ".$msgserv."</label>";

                if ($service_response['status'] == 1)
                {
                    $bdp->users()->detach($usrp->id);
                    $status = 'success';
                }
            }
            else
            {
                $msg = 'Solución o usuario no encontrados'; 
            }
        }
        else
        {
           $msg = 'Usuario o identificador de solución no enviados'; 
        }


        $response = array ('status' => $status, 'msg' => $msg);
        return \Response::json($response);
    }


     public function getBitBD(Request $request)
    {
        $alldata = $request->all();
        $bdp = BasedatosApp::find($alldata['bdid']);
        $arrayparams['dbname'] = $bdp->bdapp_nombd;
        $gener_inst = config('app.advans_apps_gener_inst.'.$bdp->bdapp_app);
        $status = 'failure';
        $result = [];
        $bitacora = [];

        if ($bdp->bdapp_app != 'fact')
        {
            $acces_vars = $this->getAccessToken($bdp->bdapp_app);
            $service_response = $this->getAppService($acces_vars['access_token'],'getbitc',$arrayparams,$bdp->bdapp_app);
            $msg = "<label  style=' color:#790D4E' class='control-label col-md-12 col-sm-12 col-xs-12'> ".$service_response['msg']."</label>";
            $status = $service_response['status'];
            $bitacora = $service_response['bitacora'];
            foreach ($bitacora as $b) {
                $navegador = json_decode($b['navegador']);
                $navegador_name = $navegador['name'];
                array_push($result, ['bitc_fecha'=>$b['bitc_fecha'],'bitcta_tipo_op'=>$b['bitcta_tipo_op'],'bitcta_ip'=>$b['bitcta_ip'],'bitc_modulo'=>$b['bitc_modulo'],'navegador'=>$navegador_name]);
            }
            
        }
        else
        {
            $msg = "<label  style=' color:#790D4E' class='control-label col-md-12 col-sm-12 col-xs-12'> ".'No aplica la acción de retornar bitácora'."</label>";
        }

        $response = array ('status' => $status, 'msg' => $msg, 'result' => $result);
        return \Response::json($response);

    }

    
}


