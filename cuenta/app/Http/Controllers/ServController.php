<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Aplicacion;
use App\Paquete;
use App\User;
use Illuminate\Support\Facades\Log;
use App\Bitacora;
use App\BasedatosApp;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class ServController extends Controller
{

	use AuthenticatesUsers;

	

    public function registrarBitacora($msg, $op, $dbname, $user_name = 'Usuario de control')
    {
    	$bitcta_msg = $msg;
		$bitc_fecha = date("Y-m-d H:i:s");
        $bitcta_tipo_op = $op;
        $bitc_modulo = '\Services';
	    $bitcta_dato = json_encode($_REQUEST);
	    
	    /*$advans_usr = DB::connection($dbname)->select('select id, name, email from users where users_control = true');
	    $bitcta_users_id = null;
	    if (count($advans_usr) > 0)
	    {
	    	$bitcta_users_id = $advans_usr[0]->id;
	    }*/

	    $bitcta_user = $user_name;
	    DB::connection($dbname)->insert('insert into bitcta (bitc_fecha, bitc_modulo, bitcta_tipo_op, bitcta_msg, bitcta_dato, bitcta_user, created_at) values (?, ?, ?, ?, ?, ?, ?)', [$bitc_fecha, $bitc_modulo, $bitcta_tipo_op, $bitcta_msg, $bitcta_dato, $bitcta_user, date('Y-m-d H:i:s')]);
    }


    public function createbd(Request $request)
    {
        $alldata = $request->all();
        $msg = "Base de datos creada satisfactoriamente.";
        $status = "Success";
        $arrayparams = [];

        if(array_key_exists('rfc_nombrebd',$alldata) && isset($alldata['rfc_nombrebd'])){
            
            $dbname = $alldata['rfc_nombrebd'].'_cta';
            $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?";
	        $db = DB::select($query, [$dbname]);

	        if(empty($db)){

	        	$strfile=file_get_contents(base_path() .'/config/database.php');
		        $dbvalue = config('database.connections');

                if(!array_key_exists($dbname,$dbvalue)){

                	$str_to_replace = "'".$dbname."' => [
		            'driver' => 'mysql',
		            'host' => env('DB_HOST', '127.0.0.1'),
		            'port' => env('DB_PORT', '3306'),
		            'database' => '".$dbname."',
		            'username' => env('DB_USERNAME', 'forge'),
		            'password' => env('DB_PASSWORD', ''),
		            'unix_socket' => env('DB_SOCKET', ''),
		            'charset' => 'utf8mb4',
		            'collation' => 'utf8mb4_unicode_ci',
		            'prefix' => '',
		            'strict' => false,
		            'engine' => null,
		        ],

		       //AddDB
		        ";
                	$strfile=str_replace("//AddDB", $str_to_replace, $strfile);
                	file_put_contents(base_path() .'/config/database.php', $strfile);
                }
                //Pedir datos de conexión a servidor para crear base de datos
		        DB::statement("create database ".$dbname);
		        \Artisan::call('config:cache');
		        \Config::set('database.connections.'.$dbname, [
		            'driver' => 'mysql',
		            'host' => env('DB_HOST', '127.0.0.1'),
		            'port' => env('DB_PORT', '3306'),
		            'database' => $dbname,
		            'username' => env('DB_USERNAME', 'forge'),
		            'password' => env('DB_PASSWORD', ''),
		            'unix_socket' => env('DB_SOCKET', ''),
		            'charset' => 'utf8mb4',
		            'collation' => 'utf8mb4_unicode_ci',
		            'prefix' => '',
		            'strict' => false,
		            'engine' => null,
		        ]);

		        \Config::set('database.default', $dbname);
		        \Artisan::call('migrate', ['--database'=>$dbname]);
		        \Artisan::call('db:seed', ['--database'=>$dbname]);
		        
		        //Guardando datos generales de la cuenta
		        DB::connection($dbname)->insert('insert into ctaconf (ctaconf_f_creacion, ctaconf_rfc) values (?, ?)', [date('Y-m-d H:i:s'), $alldata['rfc_nombrebd']]);

		        //Recuperando datos de primer usuario a crear
		        $email = 'test@gmail.com';
		        $pass = bcrypt('test');
		        $nick = 'test';
		        $name = 'test';
		        if(array_key_exists('password',$alldata) && isset($alldata['password'])){
		        	
		        	$pass = bcrypt($alldata['password']);
		        	Log::info($alldata['password']);
		        	$pass_sin_bcrypt = $alldata['password'];
		        	$arrayparams['password'] = $pass_sin_bcrypt;

		        }

		        if(array_key_exists('client_email',$alldata) && isset($alldata['client_email'])){
		        	
		        	$email = $alldata['client_email'];
		        	$arrayparams['email'] = $email;
		        	
		        }

		        if(array_key_exists('client_nick',$alldata) && isset($alldata['client_nick'])){
		        	
		            $nick = $alldata['client_nick'];

		        }

		        if(array_key_exists('client_name',$alldata) && isset($alldata['client_name'])){
		        	
		        	$name = $alldata['client_name'];
		        	$arrayparams['name'] = $name;

		        }

		        //Insertando primer usuario de base de datos de cuenta, enviado por control
		        $firstusr_id = DB::connection($dbname)->table('users')->insertGetId(['name'=>$name, 'users_nick'=>$nick,'email'=>$email, 'password'=>$pass]);
		        $arrayparams['id_cuenta'] = $firstusr_id;


		        //Insertando usuario avanzado de advans en base de datos de cuenta
		          

		        //Registrando en bitácora creación de bd
		        $bitcta_msg = 'Base de datos '.$dbname. ' creada desde control';
		        $bitcta_tipo_op = 'create account instance';
		        
		        if(array_key_exists('user_name',$alldata) && isset($alldata['user_name']))
		        {
		        	$user_name = $alldata['user_name'];
		        	$this->registrarBitacora($bitcta_msg, $bitcta_tipo_op, $dbname, $user_name);
		        }
		        else
		        {	
		        	$this->registrarBitacora($bitcta_msg, $bitcta_tipo_op, $dbname);
		        }
			    
		       
		        //Asignando primeros roles a usuarios creados
		        $mantrol_id_array = DB::connection($dbname)->select('select id from roles where slug = ?',['gestor.mantenimiento']);
		        $approl_id_array = DB::connection($dbname)->select('select id from roles where slug = ?',['gestor.aplicacion']);
		        $segurol_id_array = DB::connection($dbname)->select('select id from roles where slug = ?',['gestor.seguridad']);

		        if (count($mantrol_id_array) > 0 && count($approl_id_array) > 0 && count($segurol_id_array) > 0)
		        {
		        	DB::connection($dbname)->insert('insert into role_user (role_id, user_id) values (?, ?)', [$mantrol_id_array[0]->id, $firstusr_id]);
		        	DB::connection($dbname)->insert('insert into role_user (role_id, user_id) values (?, ?)', [$mantrol_id_array[0]->id, $advansusr_id]);
		        	DB::connection($dbname)->insert('insert into role_user (role_id, user_id) values (?, ?)', [$approl_id_array[0]->id, $firstusr_id]);
		        	DB::connection($dbname)->insert('insert into role_user (role_id, user_id) values (?, ?)', [$approl_id_array[0]->id, $advansusr_id]);

		        	DB::connection($dbname)->insert('insert into role_user (role_id, user_id) values (?, ?)', [$segurol_id_array[0]->id, $firstusr_id]);
		        	DB::connection($dbname)->insert('insert into role_user (role_id, user_id) values (?, ?)', [$segurol_id_array[0]->id, $advansusr_id]);

		        	//Asignando permisos
			        $manrperm_id_array = DB::connection($dbname)->select('select permission_id from permission_role where role_id = ?',[$mantrol_id_array[0]->id]);
			        $appperm_id_array = DB::connection($dbname)->select('select permission_id from permission_role where role_id = ?',[$approl_id_array[0]->id]);
			        $segurperm_id_array = DB::connection($dbname)->select('select permission_id from permission_role where role_id = ?',[$segurol_id_array[0]->id]);

			        foreach ($manrperm_id_array as $permm) {
			        	DB::connection($dbname)->insert('insert into permission_user (permission_id, user_id) values (?, ?)', [$permm->permission_id, $advansusr_id]);
			        	DB::connection($dbname)->insert('insert into permission_user (permission_id, user_id) values (?, ?)', [$permm->permission_id, $firstusr_id]);
			        }
			        foreach ($appperm_id_array as $perma) {
			        	DB::connection($dbname)->insert('insert into permission_user (permission_id, user_id) values (?, ?)', [$perma->permission_id, $advansusr_id]);
			        	DB::connection($dbname)->insert('insert into permission_user (permission_id, user_id) values (?, ?)', [$perma->permission_id, $firstusr_id]);
			        }
			        foreach ($segurperm_id_array as $perms) {
			        	DB::connection($dbname)->insert('insert into permission_user (permission_id, user_id) values (?, ?)', [$perms->permission_id, $advansusr_id]);
			        	DB::connection($dbname)->insert('insert into permission_user (permission_id, user_id) values (?, ?)', [$perms->permission_id, $firstusr_id]);
			        }

		        }
		        //Asignando a usuario advans permiso para leer usuarios de advans
		        $usradvans_perm_id_array = DB::connection($dbname)->select('select id from permissions where slug = ?',['leer.usuario.advans']);

		        if (count($usradvans_perm_id_array) > 0)
		        {
		        	DB::connection($dbname)->insert('insert into permission_user (permission_id, user_id) values (?, ?)', [$usradvans_perm_id_array[0]->id, $advansusr_id]);
		        }
		        
		       	//Insertando primera empresa en base de datos de cuenta		        
		        if (array_key_exists('client_f_fin',$alldata) && isset($alldata['client_f_fin']) && array_key_exists('client_f_inicio',$alldata) && isset($alldata['client_f_inicio']))
		        {
		        	//$empresa_id = DB::connection($dbname)->insertGetId('insert into empr (empr_nom, empr_rfc, empr_principal, empr_f_iniciovig, empr_f_finvig) values (?, ?, ?, ?, ?)', [$name, $alldata['client_rfc'], true, $alldata['client_f_inicio'], $alldata['client_f_fin']]);

		        	 $empresa_id = DB::connection($dbname)->table('empr')->insertGetId(['empr_nom'=>$name, 'empr_rfc'=>$$alldata['client_rfc'], 'empr_principal'=>true, 'empr_f_iniciovig'=>$alldata['client_f_inicio'], 'empr_f_finvig'=>$alldata['client_f_fin']]);
		        }
		        else 
		        {
		        	//$empresa_id = DB::connection($dbname)->insertGetId('insert into empr (empr_nom, empr_rfc, empr_principal) values (?, ?, ?)', [$name, $alldata['client_rfc'], true]);

		        	$empresa_id = DB::connection($dbname)->table('empr')->insertGetId(['empr_nom'=>$name, 'empr_rfc'=>$$alldata['client_rfc'], 'empr_principal'=>true]);
		        }

		        // Desplegando en cuenta la línea de tiempo en caso de venir
		        $dateline = '';
		        if(array_key_exists('paq_cta',$alldata) && isset($alldata['paq_cta'])){
		        	Log::info($alldata['paq_cta']);
		        	foreach (json_decode($alldata['paq_cta']) as $paqt) {
		        		$dateline = $paqt->paqapp_f_caduc;
		        		DB::connection($dbname)->insert('insert into paqapp (paqapp_f_venta, paqapp_f_fin, paqapp_f_caduc, paqapp_control_id, created_at) values (?, ?, ?, ?, ?)', [$paqt->paqapp_f_venta, $paqt->paqapp_f_fin, $paqt->paqapp_f_caduc, $paqt->paqapp_control_id, date('Y-m-d H:i:s')]);
		        	}
		        }
		        
		        // Desplegando en cuenta las aplicaciones en caso de venir
		       if(array_key_exists('apps_cta',$alldata) && isset($alldata['apps_cta'])){
		       		$gen_sol = false;

		       		if(array_key_exists('gen_sol',$alldata) && isset($alldata['gen_sol']))
			        {
			        	if ($alldata['gen_sol'])
			        	{
			        		$gen_sol = true;
			        	}
			        }

		        	
		        	$apps = json_decode($alldata['apps_cta']);
		        	
		        	foreach ($apps as $appc) {
		        		//$app_id = DB::connection($dbname)->insertGetId('insert into app (app_nom, app_cod, app_insts, app_megs, app_activa, app_estado, created_at) values (?, ?, ?, ?, ?, ?, ?)', [$appc->app_nom, $appc->app_cod, $appc->app_insts, $appc->app_megs, true, $appc->app_estado, date('Y-m-d H:i:s')]);

		        		$app_id = DB::connection($dbname)->table('app')->insertGetId(['app_nom'=>$appc->app_nom, 'app_cod'=>$appc->app_cod, 'app_insts'=>$appc->app_insts, 'app_megs'=>$appc->app_megs, 'app_activa'=>true, 'app_estado'=>$appc->app_estado, 'created_at'=>date('Y-m-d H:i:s')]);

		        		 //Creando soluciones si está marcado el campo generar soluciones en cuenta de control
		        		if ($gen_sol)
		        		{
		        			//Guardando solución en cuenta
		        			$dbnamesol = $alldata['client_rfc'].'_'.$alldata['client_rfc'].'_'.$appc->app_cod;

		        			//$bd_id = DB::connection($dbname)->insertGetId('insert into bdapp (bdapp_app, bdapp_nombd, bdapp_nomserv, bdapp_gigdisp, bdapp_empr_id, bdapp_app_id, created_at) values (?, ?, ?, ?, ?, ?, ?)', [$appc->app_cod, $dbnamesol, '', $appc->app_megs, $empresa_id, $app_id, date('Y-m-d H:i:s')]);

		        			$bd_id = DB::connection($dbname)->table('bdapp')->insertGetId(['bdapp_app'=>$appc->app_cod, 'bdapp_nombd'=>$dbnamesol, 'bdapp_nomserv'=>'', 'bdapp_gigdisp'=>$appc->app_megs, 'bdapp_empr_id'=>$empresa_id, 'bdapp_app_id'=>$app_id, 'created_at'=>date('Y-m-d H:i:s')]);

		        			DB::connection($dbname)->insert('insert into bdusr (bdusr_bdapp_id, bdusr_bdusr_id, created_at) values (?, ?, ?)', [$bd_id, $firstusr_id, date('Y-m-d H:i:s')]);


		        			//generando solución como instancia
			                $arrayparams['rfc'] = $alldata['client_rfc'];
			                $arrayparams['cta'] = $alldata['client_rfc'];
			                $arrayparams['dbname'] = $dbnamesol;
			                $url_inst = config('app.advans_apps_url.'.$appc->app_cod).'/login';
			                $arrayparams['megas'] = $appc->app_megs;
			                $arrayparams['f_corte'] = $dateline;
			                $acces_vars = $this->getAccessToken($appc->app_cod);
                			$service_response = $this->getAppService($acces_vars['access_token'],'createbd',$arrayparams,$appc->app_cod);
                			 if ($email){
				                  \Mail::to($email)->send(new InstEmail(['app'=>$appc->app_nom,'empr'=>$name,'ctarfc'=>$alldata['client_rfc'],'emprrfc'=>$alldata['client_rfc'],'user'=>$email,'password'=>$pass_sin_bcrypt,'url'=>$url_inst]));
				              }

		        		}
				        
		        	}
		        }

		        




		        \Config::set('database.default', \Session::get('selected_database','mysql'));

	        }
	        else
	        {
	        	$msg = "RFC de cuenta ya generada";
        		$status = "Failure";
	        }
	            
	    }
        else
        {

        	$msg = "RFC de cliente no recibido";
        	$status = "Failure";
        }

	         $response = array(
            'status' => $status,
            'msg' => $msg,
            'user' => $alldata);

        	return \Response::json($response);
	   }

	    //Agregar o activar nueva aplicación
	   public function addapp(Request $request){

	   		$alldata = $request->all();
	        $msg = "Aplicación añadida.";
	        $status = "Success";
	        $apps = [];
	        $dbname = '';

	        if(array_key_exists('apps_cta',$alldata) && isset($alldata['apps_cta']) && array_key_exists('rfc_nombrebd',$alldata) && isset($alldata['rfc_nombrebd'])){

	        	$apps = json_decode($alldata['apps_cta']);
	        	$dbname = $alldata['rfc_nombrebd'].'_cta';
	            $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?";
	            $db = DB::select($query, [$dbname]);
		        
		        $bitcta_tipo_op = 'add application';
		        Log::info($apps);

		        if(!empty($db)){

		        	foreach ($apps as $appc) {
		        		$appexist = DB::connection($dbname)->select('select id from app where app_cod = ?', [$appc->app_cod]);

		        		if (count($appexist) == 0){
		        			DB::connection($dbname)->insert('insert into app (app_nom, app_cod, app_insts, app_megs, app_activa, app_estado, created_at) values (?, ?, ?, ?, ?, ?, ?)', [$appc->app_nom, $appc->app_cod, $appc->app_insts, $appc->app_megs, true, $appc->app_estado, date('Y-m-d H:i:s')]);
		        			$bitcta_msg = 'Aplicación '.$appc->app_nom. ' añadida desde control';
		        		}
		        		else{
		        			DB::connection($dbname)->update('update app set app_activa = true, updated_at = ?  where app_cod = ?', [date('Y-m-d H:i:s'), $appc->app_cod]);
		        			$bitcta_tipo_op = 'activate application';
		        			$bitcta_msg = 'Aplicación '.$appc->app_nom. ' activada desde control';

		        		}

		        		if(array_key_exists('user_name',$alldata) && isset($alldata['user_name']))
				        {
				        	$user_name = $alldata['user_name'];
				        	$this->registrarBitacora($bitcta_msg, $bitcta_tipo_op, $dbname, $user_name);
				        }
				        else
				        {	
				        	$this->registrarBitacora($bitcta_msg, $bitcta_tipo_op, $dbname);
				        }
		        	}
		        }
	        }

	   		$response = array(
            'status' => $status,
            'msg' => $msg,
            'data' => $alldata,
            'apps' => $apps,
            'dbname' => $dbname);

        	return \Response::json($response);
	   }


	   	//Modificar aplicación existente
	   public function modapp(Request $request){

	   		$alldata = $request->all();
	        $msg = "Aplicación modificada.";
	        $status = "Success";
	        $apps = [];
	        $dbname = '';

	        if(array_key_exists('apps_cta',$alldata) && isset($alldata['apps_cta']) && array_key_exists('rfc_nombrebd',$alldata) && isset($alldata['rfc_nombrebd'])){

	        	$apps = json_decode($alldata['apps_cta']);
	        	$dbname = $alldata['rfc_nombrebd'].'_cta';
	            $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?";
	            $db = DB::select($query, [$dbname]);

		        $bitcta_tipo_op = 'update application';
			    
		        if(!empty($db)){

		        	foreach ($apps as $appc) {

		        		DB::connection($dbname)->update('update app set app_insts = ?, app_megs = ?, app_estado = ?, updated_at = ? where app_cod = ?', [$appc->app_insts, $appc->app_megs, $appc->app_estado, date('Y-m-d H:i:s'), $appc->app_cod]);
		        		
		        		$bitcta_msg = 'Aplicación '.$appc->app_nom. ' actualizada desde control';
		        		if(array_key_exists('user_name',$alldata) && isset($alldata['user_name']))
				        {
				        	$user_name = $alldata['user_name'];
				        	$this->registrarBitacora($bitcta_msg, $bitcta_tipo_op, $dbname, $user_name);
				        }
				        else
				        {	
				        	$this->registrarBitacora($bitcta_msg, $bitcta_tipo_op, $dbname);
				        }
		        	}
		        }
	        }

	   		$response = array(
            'status' => $status,
            'msg' => $msg,
            'data' => $alldata,
            'apps' => $apps,
            'dbname' => $dbname);

        	return \Response::json($response);
	   }

	   //Desactivar aplicación existente
	   public function desactapp(Request $request){

	   		$alldata = $request->all();
	        $msg = "Aplicación desactivada.";
	        $status = "Success";
	        $apps = [];
	        $dbname = '';

	        if(array_key_exists('apps_cta',$alldata) && isset($alldata['apps_cta']) && array_key_exists('rfc_nombrebd',$alldata) && isset($alldata['rfc_nombrebd'])){

	        	$apps = json_decode($alldata['apps_cta']);
	        	$dbname = $alldata['rfc_nombrebd'].'_cta';
	            $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?";
	            $db = DB::select($query, [$dbname]);
	            
		        $bitcta_tipo_op = 'disable application';
			    
		        if(!empty($db)){

		        	foreach ($apps as $appc) {
		        		
		        		DB::connection($dbname)->update('update app set app_activa = false, updated_at = ?  where app_cod = ?', [date('Y-m-d H:i:s'), $appc->app_cod]);

		        		$bitcta_msg = 'Aplicación '.$appc->app_nom. ' desactivada desde control';
		        		if(array_key_exists('user_name',$alldata) && isset($alldata['user_name']))
				        {
				        	$user_name = $alldata['user_name'];
				        	$this->registrarBitacora($bitcta_msg, $bitcta_tipo_op, $dbname, $user_name);
				        }
				        else
				        {	
				        	$this->registrarBitacora($bitcta_msg, $bitcta_tipo_op, $dbname);
				        }
		        	}
		        }
	        }

	   		$response = array(
            'status' => $status,
            'msg' => $msg,
            'data' => $alldata,
            'apps' => $apps,
            'dbname' => $dbname);

        	return \Response::json($response);
	   }

	   //Eliminar aplicación existente
	   public function delapp(Request $request){

	   		$alldata = $request->all();
	        $msg = "Aplicación eliminada.";
	        $status = "success";
	        $apps = [];
	        $dbname = '';

	        if(array_key_exists('apps_cta',$alldata) && isset($alldata['apps_cta']) && array_key_exists('rfc_nombrebd',$alldata) && isset($alldata['rfc_nombrebd'])){

	        	$apps = json_decode($alldata['apps_cta']);
	        	$dbname = $alldata['rfc_nombrebd'].'_cta';
	            $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?";
	            $db = DB::select($query, [$dbname]);
		        

		        if(!empty($db)){

		        	foreach ($apps as $appc) {

		        		$app = DB::connection($dbname)->table('app')->where('app_cod', '=', $appc->app_cod)->get();
		        		if (count($app) > 0){
		        			$bdapp = DB::connection($dbname)->table('bdapp')->where('bdapp_app_id', '=', $app[0]->id)->get();
		        			$bitcta_msg = 'Aplicación '.$app[0]->app_nom. ' eliminada desde control';
					        $bitcta_tipo_op = 'delete application';
						    
		        			if (count($bdapp) == 0)
		        			{
		        				DB::connection($dbname)->table('app')->where('id', '=', $app[0]->id)->delete();
		        			}
		        			else
		        			{
		        				$bitcta_msg = 'Intento fallido de eliminación de aplicación '.$app[0]->app_nom. ' desde control, existen base de datos dependientes';
		        				$msg = "Aplicación no eliminada pues tiene bases de datos dependientes.";
		        				$status = "failure";
		        				
		        			}
		        			if(array_key_exists('user_name',$alldata) && isset($alldata['user_name']))
					        {
					        	$user_name = $alldata['user_name'];
					        	$this->registrarBitacora($bitcta_msg, $bitcta_tipo_op, $dbname, $user_name);
					        }
					        else
					        {	
					        	$this->registrarBitacora($bitcta_msg, $bitcta_tipo_op, $dbname);
					        }
		        		}
		        	}
		        }
	        }

	   		$response = array(
            'status' => $status,
            'msg' => $msg,
            'data' => $alldata,
            'apps' => $apps,
            'dbname' => $dbname);

        	return \Response::json($response);
	   }

	   //Método para modificar actual línea de tiempo
	   public function modpaq(Request $request){

	   		$alldata = $request->all();
	        $msg = "Paquete modificado.";
	        $status = "Success";

	        if(array_key_exists('paq_cta',$alldata) && isset($alldata['paq_cta']) && array_key_exists('rfc_nombrebd',$alldata) && isset($alldata['rfc_nombrebd'])){

	        	$paqs = json_decode($alldata['paq_cta']);
	        	$dbname = $alldata['rfc_nombrebd'].'_cta';
	            $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?";
	            $db = DB::select($query, [$dbname]);

	            
		        $bitcta_tipo_op = 'update timeline';
			    
		        
		        if(!empty($db)){

		        	foreach ($paqs as $paqt) {
		        		DB::connection($dbname)->update('update paqapp set paqapp_f_fin = ?, paqapp_f_caduc = ?, updated_at = ? where paqapp_control_id = ?', [$paqt->paqapp_f_fin, $paqt->paqapp_f_caduc, date('Y-m-d H:i:s'), $paqt->paqapp_control_id]);

		        		$bitcta_msg = 'Línea de tiempo con id de control '. $paqt->paqapp_control_id.' modificada desde control';

		        		if(array_key_exists('user_name',$alldata) && isset($alldata['user_name']))
				        {
				        	$user_name = $alldata['user_name'];
				        	$this->registrarBitacora($bitcta_msg, $bitcta_tipo_op, $dbname, $user_name);
				        }
				        else
				        {	
				        	$this->registrarBitacora($bitcta_msg, $bitcta_tipo_op, $dbname);
				        }
		        	}
		        }
	        }

	   		$response = array(
            'status' => $status,
            'msg' => $msg,
            'data' => $alldata);

        	return \Response::json($response);
	   }

	   	//Marcar línea de tiempo como pagada
	   public function pagpaq(Request $request){

	   		$alldata = $request->all();
	        $msg = "Paquete modificado.";
	        $status = "Success";

	        if(array_key_exists('paq_cta',$alldata) && isset($alldata['paq_cta']) && array_key_exists('rfc_nombrebd',$alldata) && isset($alldata['rfc_nombrebd'])){

	        	$paqs = json_decode($alldata['paq_cta']);
	        	$dbname = $alldata['rfc_nombrebd'].'_cta';
	            $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?";
	            $db = DB::select($query, [$dbname]);

		        $bitcta_tipo_op = 'pay timeline';
			   
		        if(!empty($db)){

		        	foreach ($paqs as $paqt) {
		        		DB::connection($dbname)->update('update paqapp set paqapp_pagado = true, updated_at = ? where paqapp_control_id = ?', [date('Y-m-d H:i:s'), $paqt->paqapp_control_id]);
		        		$bitcta_msg = 'Línea de tiempo con id de control '.$paqt->paqapp_control_id.' marcada como pagada';

		        		if(array_key_exists('user_name',$alldata) && isset($alldata['user_name']))
				        {
				        	$user_name = $alldata['user_name'];
				        	$this->registrarBitacora($bitcta_msg, $bitcta_tipo_op, $dbname, $user_name);
				        }
				        else
				        {	
				        	$this->registrarBitacora($bitcta_msg, $bitcta_tipo_op, $dbname);
				        }
		        	}
		        }
	        }

	   		$response = array(
            'status' => $status,
            'msg' => $msg,
            'data' => $alldata);

        	return \Response::json($response);
	   }


	   //Método para agregar nueva línea de tiempo
	   public function addpaq(Request $request){

	   		$alldata = $request->all();
	        $msg = "Línea de tiempo añadida.";
	        $status = "Success";



	        if(array_key_exists('paq_cta',$alldata) && isset($alldata['paq_cta']) && array_key_exists('rfc_nombrebd',$alldata) && isset($alldata['rfc_nombrebd'])){

	        	$paqs = json_decode($alldata['paq_cta']);
	        	$dbname = $alldata['rfc_nombrebd'].'_cta';
	            $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?";
	            $db = DB::select($query, [$dbname]);

		        $bitcta_tipo_op = 'add timeline';
			    
		        if(!empty($db)){
		        	DB::connection($dbname)->update('update paqapp set paqapp_activo = false');

		        	foreach ($paqs as $paqt) {
		        		DB::connection($dbname)->insert('insert into paqapp (paqapp_f_venta, paqapp_f_fin, paqapp_f_caduc, paqapp_control_id, created_at) values (?, ?, ?, ?, ?)', [$paqt->paqapp_f_venta, $paqt->paqapp_f_fin, $paqt->paqapp_f_caduc, $paqt->paqapp_control_id, date('Y-m-d H:i:s')]);
		        		$bitcta_msg = 'Nueva línea de tiempo con id de control '.$paqt->paqapp_control_id.' añadida';

		        		if(array_key_exists('user_name',$alldata) && isset($alldata['user_name']))
				        {
				        	$user_name = $alldata['user_name'];
				        	$this->registrarBitacora($bitcta_msg, $bitcta_tipo_op, $dbname, $user_name);
				        }
				        else
				        {	
				        	$this->registrarBitacora($bitcta_msg, $bitcta_tipo_op, $dbname);
				        }
		        	}
		        }
	        }

	   		$response = array(
            'status' => $status,
            'msg' => $msg,
            'data' => $alldata);

        	return \Response::json($response);
	   }

	   	//Borrar línea de tiempo
	   public function delpaq(Request $request){

	   		$alldata = $request->all();
	        $msg = "Línea de tiempo eliminada.";
	        $status = "Success";

	        if(array_key_exists('paq_cta',$alldata) && isset($alldata['paq_cta']) && array_key_exists('rfc_nombrebd',$alldata) && isset($alldata['rfc_nombrebd'])){

	        	$paqs = json_decode($alldata['paq_cta']);
	        	$dbname = $alldata['rfc_nombrebd'].'_cta';
	            $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?";
	            $db = DB::select($query, [$dbname]);

		        $bitcta_tipo_op = 'delete timeline';
			    
		        
		        if(!empty($db)){
		        	foreach ($paqs as $paqt) {
		        		DB::connection($dbname)->table('paqapp')->where('paqapp_control_id', '=', $paqt->paqapp_control_id)->delete();
		        		Log::info($paqt->paqapp_control_id);

		        		$bitcta_msg = 'Línea de tiempo con id de control '.$paqt->paqapp_control_id.' eliminada';
		        		if(array_key_exists('user_name',$alldata) && isset($alldata['user_name']))
				        {
				        	$user_name = $alldata['user_name'];
				        	$this->registrarBitacora($bitcta_msg, $bitcta_tipo_op, $dbname, $user_name);
				        }
				        else
				        {	
				        	$this->registrarBitacora($bitcta_msg, $bitcta_tipo_op, $dbname);
				        }
		        	}
		        }
	        }

	   		$response = array(
            'status' => $status,
            'msg' => $msg,
            'data' => $alldata);

        	return \Response::json($response);
	   }


	   //Método para desbloquear desde control usuario bloqueado por 3 intentos fallidos de login
	   public function unlockUserControl(Request $request)
	   {
	   		$alldata = $request->all();
	   		if(array_key_exists('user_id',$alldata) && isset($alldata['user_id']) && array_key_exists('dbname',$alldata) && isset($alldata['dbname'])){

	   			$dbname = $alldata['dbname'].'_cta';
	   			$usr = DB::connection($dbname)->table('users')->where('id', '=', $alldata['user_id'])->get();
		        $bitcta_tipo_op = 'unlock user';
			    	   			
	   			if (count($usr) > 0)
	   			{
	   				$bitcta_msg = 'Desbloqueo desde control de usuario '.$usr[0]->name;
	    			
			        DB::connection($dbname)->update('update users set users_blocked = false where id = ?', [$usr[0]->id]);
			        //$this->clearLoginAttempts($request, $usr->email);
        			
			        $key = '%' . $usr[0]->email . '%';

			        DB::connection($dbname)->table('cache')->where('cache.key', 'like', $key)->delete();
	   			}
	   			else
	   			{
	   				//llamar usuario admin de bd y ponerlo como usuario
	   				$bitcta_msg = 'Intento de desbloqueo desde control de usuario no existente en base de datos'.$alldata['dbname'];

		   		}
		   		if(array_key_exists('user_name',$alldata) && isset($alldata['user_name']))
		        {
		        	$user_name = $alldata['user_name'];
		        	$this->registrarBitacora($bitcta_msg, $bitcta_tipo_op, $dbname, $user_name);
		        }
		        else
		        {	
		        	$this->registrarBitacora($bitcta_msg, $bitcta_tipo_op, $dbname);
		        }
	   		}
	   }

	   //Limpia intentos de login para desbloquear usuario
	   protected function clearLoginAttempts(Request $request, $email = '')
	    {
	        if ($email != ''){
	            $this->limiter()->clear($email);
	        }
	        else{
	            $this->limiter()->clear($this->throttleKey($request));
	        }
	    }
	   
	   //Retorna listado de usuarios con estado para control
	   public function returnUsersControl(Request $request){

		   	$alldata = $request->all();
		   	$users = [];
		   	if (array_key_exists('dbname',$alldata) && isset($alldata['dbname'])){
		   		$dbname = $alldata['dbname'].'_cta';
		   		$users = DB::connection($dbname)->select('select id, name, email, users_blocked from users;');
		   	}

		   	return \Response::json($users);
	   }

	   //Retorna bitácora para control
	   public function getBitControl(Request $request){
	   	
	    	$alldata = $request->all();
	   		$bitacoras = [];

	   		if (array_key_exists('dbname',$alldata) && isset($alldata['dbname'])){
	   			$dbname = $alldata['dbname'].'_cta';
	   			$bitacoras = DB::connection($dbname)->select('select bitc_fecha, bitc_modulo, bitcta_ip, bitcta_tipo_op, bitcta_msg from bitcta order by bitc_fecha DESC limit 10;');
	   		}
	        return \Response::json($bitacoras);
	    }


	    //Verifica si existe determinada instancia
	     public function verifyInstance(Request $request){
	   		Log::info('entro');
	    	$alldata = $request->all();
	   		$status = 1;
	   		$msg = 'Existe solución';
	   		$bloq = false;

	   		if (array_key_exists('cta',$alldata) && isset($alldata['cta']) && array_key_exists('dbname',$alldata) && isset($alldata['dbname']))
	   		{

	   			$dbcon = $alldata['cta'].'_cta';
	   			$instdbname = $alldata['dbname'];

	   			$cta_bloq = DB::connection($dbcon)->select('select ctaconf_bloq from ctaconf');

	   			if (count($cta_bloq) > 0)
	   			{
	   				$bloq = $cta_bloq[0];
	   			}

	   			$dbapps = DB::connection($dbcon)->table('bdapp')->where('bdapp_nombd', '=', $instdbname)->get();

	   			if (count($dbapps) == 0)
	   			{
	   				$status = 0;
	   				$msg = 'RFC o número de cuenta no registrado';
	   			}
	   			else
	   			{
	   				$app_id = $dbapps[0]->bdapp_app_id;
	   				$app = DB::connection($dbcon)->table('app')->where('id', '=', $app_id)->get();
	   				if (count($app) > 0)
	   				{
	   					if (!$bloq)
	   					{
	   						if ($app[0]->app_activa == false)
		   					{
		   						$status = 0;
		   						$msg = 'Aplicación bloqueada desde control';
		   					}
	   					}
	   					else
	   					{
	   						$status = 0;
		   					$msg = 'Cuenta bloqueada';
	   					}
	   					
	   				}
	   				
	   			}

	   		}

	   		$response = array(
            'status' => $status,
            'msg' => $msg,
            'data' => $alldata);

        	return \Response::json($response);
	    }
    }

