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

class AppController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

     public function index()
    {       
        $usrs = User::all();
        $apps = BasedatosApp::all();

        return view('apps',['apps'=>$apps,'usrs'=>$usrs]);
    }

    public function create()
    {       


    	$empresa = Empresa::all();
        $aplicaciones = Aplicacion::all();
        return view('appcreate',['empresas'=>$empresa,'aplicaciones'=>$aplicaciones]);
    }

    public function store(Request $request)
    {
    	
        
        $bdapps = BasedatosApp::all();
    	$emprexist = null;
        $appexist = null;

    	foreach ($bdapps as $a )
    	{
    		if ($a->bdapp_app_id == $request->bdapp_app_id && $a->bdapp_empr_id == $request->bdapp_empr_id)
    		{
    			$emprexist = Empresa::find($a->bdapp_empr_id)->empr_nom;
                $appexist = Aplicacion::find($a->bdapp_app_id)->app_nom;

    		}
    	}
    	
    	if ($emprexist != null)
    	{
	    	\Session::flash('message','Ya existe la aplicación '.$appexist. ' de '.$emprexist);
	    	return redirect()->route('apps.create');
    	}

    	$appbd = new BasedatosApp;
    	$empresa = Empresa::find($request->bdapp_empr_id);
        $app = Aplicacion::find($request->bdapp_app_id);
        $dbs = BasedatosApp::where('bdapp_app', '=', $app->app_cod)->get();
        $fmessage = 'No se puede generar la aplicación '.$app->app_nom." de la empresa ".$empresa->empr_nom.' pues ha alcanzado el límite máximo de instancias contratadas para la aplicación '.$app->app_nom;
        $instlimit = $app->app_insts;
        if ($instlimit == null || count($dbs) <  $instlimit)
        {
            $appbd->bdapp_app_id = $request->bdapp_app_id;
            $appbd->bdapp_app = $app->app_cod;
            $appbd->bdapp_empr_id = $request->bdapp_empr_id;
            //llamar archivo de configuracion para seleccionar base de datos
            $appbd->bdapp_nomserv = 'Test';
            $appbd->bdapp_nombd =  $empresa->empr_rfc.'_'.$app->app_cod;
            $appbd->save();

            //Llamar a servicio web que genera base de datos en aplicación

            //$caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVXWYZ0123456789!"$%&/()=?¿*/[]{}.,;:';
            //$password = $this->rand_chars($caracteres,8);
            //$resultm = preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&#.$($)$-$_])[a-zA-Z\d$@$!%*?&#.$($‌​)$-$_]{8,50}$/u', $password, $matchesm);

            //while(!$resultm || count($matchesm) == 0){
            //    $password = $this->rand_chars($caracteres,8);
            //    $resultm = preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&#.$($)$-$_])[a-zA-Z\d$@$!%*?&#.$($‌​)$-$_]{8,50}$/u', $password, $matchesm);
            //}

            //$arrayparams['nombrebd'] = $empresa->empr_rfc.'_'.$app->app_cod;
            //$user = \Auth::user();
            //$user_email = $user->email;
            //$arrayparams['email'] = $user_email;
            //$arrayparams['name'] = $user->name;
            //$arrayparams['password'] = $password;


            //if ($user_email){
                //TODO Descomentar cuando se desbloquee el puerto 587 para enviar correo al cliente
                //Mail::to($cliente_correo)->send(new ClientCreate(['user'=>$user_email,'password'=>$password]));
            //}

            //$acces_vars = $this->getAccessToken($app->app_cod);
            //$service_response = $this->getAppService($acces_vars['access_token'],'createbd',$arrayparams,$app->app_cod);
            

            $fmessage = 'Se ha generado la aplicación '.$app->app_nom." de la empresa ".$empresa->empr_nom;
            $this->registroBitacora($request,'create',$fmessage); 
            \Session::flash('message',$fmessage);
            return Redirect::to('apps');

        }

        \Session::flash('failmessage',$fmessage);
        return Redirect::to('apps');
        


    	

        


    }

     public function destroy($id, Request $request)
    {
        
        $appd = BasedatosApp::find($id);
        $appd->users()->detach();
        $appd-> backups()->delete();

        $appd->delete();
        $fmessage = 'Se ha eliminado la base de datos de aplicación: '.$appd->bdapp_nombd;
        $this->registroBitacora($request,'delete',$fmessage); 
        \Session::flash('message',$fmessage);

        return Redirect::to('apps');


    }


    public function edit($id)
    {       

        $empresa = Empresa::all();

        $appe = BasedatosApp::find($id);
        return view('appedit',['app'=>$appe,'empresas'=>$empresa]);
    }

    public function update(Request $request, $id)
    {
        $appu = BasedatosApp::find($id);
        $app = Aplicacion::where('app_cod', '=', $request->bdapp_app)->get();



        $appu->bdapp_app_id =  $app[0]->id;
        $appu->bdapp_app = $app[0]->app_cod;
        //TODO llamar archivo de configuracion para seleccionar base de datos
        $appu->bdapp_nomserv = 'Test';
        $appu->bdapp_empr_id = $request->bdapp_empr_id;
        
        
        $appu->save();
        $fmessage = 'Se ha actualizado la aplicación: '.$app[0]->app_nom.', de la empresa: '.$appu->empresa->empr_nom;
        $this->registroBitacora($request,'update',$fmessage); 
        \Session::flash('message',$fmessage);
        return Redirect::to('apps');

    }

    public function relateAppUsr(Request $request)
    {
        $alldata = $request->all();

        /*echo "<pre>";
        print_r($alldata);die();
        echo "</pre>";*/

     
        if(array_key_exists('usrid',$alldata) && isset($alldata['usrid']) && array_key_exists('bdid',$alldata) && isset($alldata['bdid'])){
        
            $usrp = User::find($alldata['usrid']);
            $bdp = BasedatosApp::find($alldata['bdid']);
            $exist = False;
            if($bdp){
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
                     $stringroles = '';
                     $bdp->users()->attach($alldata['usrid']);
                     $usrarray = array('name'=>$usrp->name,'correo'=>$usrp->email,'telef'=>$usrp->users_tel, 'user'=>$usrp->users_nick,'password'=>$usrp->password,'id_cuenta'=>$usrp->id);
                     
                     
                     
                     //TODO consumir servicio para guardar usuario con roles asociados, pasando usuario, arreglo de roles con slug de cada rol y nombre de bd
                     //$app_cod = $bdp->aplicacion->app_cod;
                     //$arrayparams['usr'] = $usrarray;
                     //$arrayparams['bd'] = $bdp->bdapp_nombd;
                     //$arrayparams['roles'] = $alldata['roles'];

                     //$acces_vars = $this->getAccessToken($app_cod);
                    //$service_response = $this->getAppService($acces_vars['access_token'],'relateusr',$arrayparams,$app_cod);

                    $btn = '<div 
                class="btn-group'.$usrp->id.'">
                    <button id="desvusrbtn'.$usrp->id.'" onclick="unrelatedb('.$usrp->id.', '.$bdp->id.');" class="btn btn-xs" data-placement="left" title="Desasociar usuario" style=" color:#053666; background-color:#FFFFFF;"><i class="fa fa-close fa-3x"></i> </button></div>';
                     $response = array ('status' => 'Success', 'roles'=> $alldata['roles'], 'result' => '<tr id="row'.$usrp->id.'">
                                     <td>' . $usrp->name . '</td>' .
                                    '<td>' . $usrp->email . '</td>' .
                                    '<td>' . $usrp->users_tel . '</td>' .

                                    '<td>' . $btn . '</td>' .

                                    '</tr>');
                }

            }
            else
            {
                $response = array ('status' => 'Failure', 'result' => "<label  style=' color:#790D4E' class='control-label col-md-12 col-sm-12 col-xs-12'>Base de datos no encontrada</label>");

            }
            
        }
        else
        {

            $response = array ('status' => 'Failure', 'result' => "<label  style=' color:#790D4E' class='control-label col-md-12 col-sm-12 col-xs-12'>Usuario o base de datos no encontrados</label>");
        }
       
        return \Response::json($response);
    }


    public function unrelateAppUsr(Request $request)
    {
        $alldata = $request->all();
        if(array_key_exists('usrid',$alldata) && isset($alldata['usrid']) && array_key_exists('bdid',$alldata) && isset($alldata['bdid'])){
            $usrp = User::find($alldata['usrid']);
            $bdp = BasedatosApp::find($alldata['bdid']);
            if ($bdp){
                $bdp->users()->detach($alldata['usrid']);

                //TODO consumir servicio para eliminar usuario
                //$app_cod = $bdp->aplicacion->app_cod;
                //$arrayparams['id_cuenta'] = $usrp->id;
                //$arrayparams['bd'] = $bdp->bdapp_nombd;

                //$acces_vars = $this->getAccessToken($app_cod);
                //$service_response = $this->getAppService($acces_vars['access_token'],'unrelateusr',$arrayparams,$app_cod);
            }
        }

        $response = array ('status' => 'Success', 'result' => "Usuario eliminado de base de datos de aplicación");
        return \Response::json($response);
        

    }


     public function getBitBD(Request $request)
    {
        $alldata = $request->all();
        //TODO llamar a servicio que devuelve bitácora de aplicación, pasando nombre de base de datos específica
        //$bdp = BasedatosApp::find($alldata['bdid']);
        //$arrayparams['bd'] = $bdp->bdapp_nombd;

        //$acces_vars = $this->getAccessToken($bdp->bdapp_app);
        //$service_response = $this->getAppService($acces_vars['access_token'],'getbitc',$arrayparams,$bdp->bdapp_app);
        $bitacoras = Bitacora::latest()->take(10)->get();

        $response = array ('status' => 'Success', 'result' => $bitacoras);
        return \Response::json($response);

    }

    
}


