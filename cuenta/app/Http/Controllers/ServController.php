<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Aplicacion;
use App\Paquete;
use App\User;
use Illuminate\Support\Facades\Log;
use App\Bitacora;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class ServController extends Controller
{

	use AuthenticatesUsers;


    public function createbd(Request $request)
    {
        $alldata = $request->all();
        $msg = "Base de datos creada satisfactoriamente.";
        $status = "Success";

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
		        \Artisan::call('migrate');

		        //Creando usuario para primera conexión a cuenta TODO: poner datos de usuario correctos

		        $email = 'test@gmail.com';
		        $pass = bcrypt('test');
		        $nick = 'test';
		        $name = 'test';
		        if(array_key_exists('client_rfc',$alldata) && isset($alldata['client_rfc'])){
		        	
		        	$pass = bcrypt($alldata['client_rfc']);

		        }

		        if(array_key_exists('client_email',$alldata) && isset($alldata['client_email'])){
		        	
		        	$email = $alldata['client_email'];
		        	
		        }

		        if(array_key_exists('client_nick',$alldata) && isset($alldata['client_nick'])){
		        	
		            $nick = $alldata['client_nick'];

		        }

		        if(array_key_exists('client_name',$alldata) && isset($alldata['client_name'])){
		        	
		        	$name = $alldata['client_name'];

		        }

		        DB::connection($dbname)->insert('insert into users (name, users_nick, email, password) values (?, ?, ?, ?)', [$name, $nick,$email, $pass]);

		        DB::connection($dbname)->insert('insert into users (name, users_nick, email, password) values (?, ?, ?, ?)', ['Usuario Advans', 'advans','advans@advans.mx', bcrypt('advans')]);

		        
		        if (array_key_exists('client_f_fin',$alldata) && isset($alldata['client_f_fin']) && array_key_exists('client_f_inicio',$alldata) && isset($alldata['client_f_inicio']))
		        {
		        	DB::connection($dbname)->insert('insert into empr (empr_nom, empr_rfc, empr_principal, empr_f_iniciovig, empr_f_finvig) values (?, ?, ?, ?, ?)', [$name, $alldata['client_rfc'], true, $alldata['client_f_inicio'], $alldata['client_f_fin']]);
		        }
		        else 
		        {
		        	DB::connection($dbname)->insert('insert into empr (empr_nom, empr_rfc, empr_principal) values (?, ?, ?)', [$name, $alldata['client_rfc'], true]);
		        }
		        

		        // Desplegando en cuenta las aplicaciones y paquete contratados en control
		        
		       if(array_key_exists('apps_cta',$alldata) && isset($alldata['apps_cta'])){

		        	
		        	$apps = json_decode($alldata['apps_cta']);
		        	
		        	foreach ($apps as $appc) {
		        		DB::connection($dbname)->insert('insert into app (app_nom, app_cod, created_at) values (?, ?, ?)', [$appc->app_nom, $appc->app_cod, date('Y-m-d H:i:s')]);
		        	}

		        	Log::info($alldata['paq_cta']);
		        	foreach (json_decode($alldata['paq_cta']) as $paqt) {

		        		DB::connection($dbname)->insert('insert into paqapp (paqapp_cantrfc, paqapp_cantgig, paqapp_f_venta, paqapp_f_act, paqapp_f_fin, paqapp_f_caduc, paqapp_control_id, created_at) values (?, ?, ?, ?, ?, ?, ?, ?)', [$paqt->paqapp_cantrfc, $paqt->paqapp_cantgig, $paqt->paqapp_f_venta, $paqt->paqapp_f_act, $paqt->paqapp_f_fin, $paqt->paqapp_f_caduc, $paqt->paqapp_control_id, date('Y-m-d H:i:s')]);
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

	    public function addpaq(Request $request){
	    	$alldata = $request->all();
	        $msg = "Paquete agregado satisfactoriamente.";
	        $status = "Success";

	        if(array_key_exists('paq_cta',$alldata) && isset($alldata['paq_cta']) && array_key_exists('rfc_nombrebd',$alldata) && isset($alldata['rfc_nombrebd'])){
	        	$dbname = $alldata['rfc_nombrebd'].'_cta';

	        	foreach (json_decode($alldata['paq_cta']) as $paqt) {

		        		DB::connection($dbname)->insert('insert into paqapp (paqapp_cantrfc, paqapp_cantgig, paqapp_f_venta, paqapp_f_act, paqapp_f_fin, paqapp_f_caduc, paqapp_control_id, created_at) values (?, ?, ?, ?, ?, ?, ?, ?)', [$paqt->paqapp_cantrfc, $paqt->paqapp_cantgig, $paqt->paqapp_f_venta, $paqt->paqapp_f_act, $paqt->paqapp_f_fin, $paqt->paqapp_f_caduc, $paqt->paqapp_control_id, date('Y-m-d H:i:s')]);
		        	}

		        if(array_key_exists('apps_cta',$alldata) && isset($alldata['apps_cta'])){
		        	Log::info(json_decode($alldata['apps_cta']));
			        foreach (json_decode($alldata['apps_cta']) as $appc) {
			        		DB::connection($dbname)->insert('insert into app (app_nom, app_cod, created_at) values (?, ?, ?)', [$appc->app_nom, $appc->app_cod, date('Y-m-d H:i:s')]);
			        	}
			        }

	        }


	    }


	    
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
		        

		        if(!empty($db)){

		        	foreach ($apps as $appc) {
		        		$appexist = DB::connection($dbname)->select('select id from app where app_cod = ?', [$appc->app_cod]);

		        		if (count($appexist) == 0){
		        			DB::connection($dbname)->insert('insert into app (app_nom, app_cod, created_at) values (?, ?, ?)', [$appc->app_nom, $appc->app_cod, date('Y-m-d H:i:s')]);
		        		}
		        		else{
		        			DB::connection($dbname)->update('update app set app_activa = true, updated_at = ?  where app_cod = ?', [date('Y-m-d H:i:s'), $appc->app_cod]);

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
		        

		        if(!empty($db)){

		        	foreach ($apps as $appc) {
		        		
		        		DB::connection($dbname)->update('update app set app_activa = false, updated_at = ?  where app_cod = ?', [date('Y-m-d H:i:s'), $appc->app_cod]);
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


	   public function modpaq(Request $request){

	   		$alldata = $request->all();
	        $msg = "Paquete modificado.";
	        $status = "Success";

	        if(array_key_exists('paq_cta',$alldata) && isset($alldata['paq_cta']) && array_key_exists('rfc_nombrebd',$alldata) && isset($alldata['rfc_nombrebd'])){

	        	$paqs = json_decode($alldata['paq_cta']);
	        	$dbname = $alldata['rfc_nombrebd'].'_cta';
	            $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?";
	            $db = DB::select($query, [$dbname]);
		        
		        if(!empty($db)){

		        	foreach ($paqs as $paqt) {
		        		DB::connection($dbname)->update('update paqapp set paqapp_cantrfc = ?, paqapp_cantgig = ?, paqapp_f_fin = ?, paqapp_f_caduc = ?, updated_at = ? where paqapp_control_id = ?', [$paqt->paqapp_cantrfc, $paqt->paqapp_cantgig, $paqt->paqapp_f_fin, $paqt->paqapp_f_caduc, date('Y-m-d H:i:s'), $paqt->paqapp_control_id]);
		        	}
		        }

	        }


	   		$response = array(
            'status' => $status,
            'msg' => $msg,
            'data' => $alldata,
            'paqs' => $paqs,
            'dbname' => $dbname);

        	return \Response::json($response);
	   }

	   //Método para desbloquear desde control usuario bloqueado por 5 intentos fallidos de login
	   public function unlockUserControl(Request $request)
	   {

	   		$alldata = $request->all();
	   		if(array_key_exists('user_id',$alldata) && isset($alldata['user_id']) && array_key_exists('dbname',$alldata) && isset($alldata['dbname'])){

	   			$dbname = $alldata['dbname'].'_cta';
	   			$usr = DB::connection($dbname)->table('users')->where('id', '=', $alldata['user_id'])->get();
	   			//$usr = User::find($alldata['user_id']);
	   			$bitc_fecha = date("Y-m-d H:i:s");
		        $bitcta_tipo_op = 'control access';
		        $bitc_modulo = '\Login';
			    $bitcta_dato = json_encode($_REQUEST);
		        

	   			if (count($usr) > 0){
	   				
	   				$bitcta_users_id = $alldata['user_id'];
			        $bitcta_msg = 'Desbloqueo desde control de usuario '.$usr[0]->name;
			        DB::connection($dbname)->update('update users set users_blocked = false where id = ?', [$usr[0]->id]);
			        //$this->clearLoginAttempts($request, $usr->email);
        			//Log::info(DB::connection($dbname)->table('cache')->where('cache.key', 'like', '"%'.$usr->email.'%"')->get());

			        $key = '%' . $usr[0]->email . '%';

			        Log::info($usr[0]->email);

			        Log::info(DB::connection($dbname)->table('cache')->where('cache.key', 'like', $key)->get());
			        DB::connection($dbname)->table('cache')->where('cache.key', 'like', $key)->delete();

			        

	   			}else{
	   				//llamar usuario admin de bd y ponerlo como usuario
	   				$usradmin = User::where('users_nick', '=', 'advans')->get();
	   				$bitcta_users_id = $usradmin[0]->id;
	   				$bitcta_msg = 'Intento de desbloqueo desde control de usuario no existente en base de datos'.$alldata['dbname'];

	   			}

	   			DB::connection($dbname)->insert('insert into bitcta (bitc_fecha, bitc_modulo, bitcta_tipo_op, bitcta_msg, bitcta_users_id, created_at) values (?, ?, ?, ?, ?, ?)', [$bitc_fecha, $bitc_modulo, $bitcta_tipo_op, $bitcta_msg, $bitcta_users_id, date('Y-m-d H:i:s')]);
		   		
		   		

	   		}


	   }

	   protected function clearLoginAttempts(Request $request, $email = '')
	    {
	        if ($email != ''){
	            $this->limiter()->clear($email);
	        }
	        else{
	            $this->limiter()->clear($this->throttleKey($request));
	        }
	        
	    }
	   
	   public function returnUsersControl(Request $request){

	   	$alldata = $request->all();
	   	$users = [];
	   	if (array_key_exists('dbname',$alldata) && isset($alldata['dbname'])){
	   		$dbname = $alldata['dbname'].'_cta';

	   		$users = DB::connection($dbname)->select('select id, name, email, users_blocked from users;');
	   	}

	   	return \Response::json($users);

	   }


	   public function getBitControl(Request $request){
	   	
	    	$alldata = $request->all();
	   		$bitacoras = [];

	   		if (array_key_exists('dbname',$alldata) && isset($alldata['dbname'])){
	   			$dbname = $alldata['dbname'].'_cta';
	   			$bitacoras = DB::connection($dbname)->select('select bitc_fecha, bitc_modulo, bitcta_ip, bitcta_tipo_op, bitcta_msg from bitcta order by bitc_fecha DESC limit 10;');
	   		}
	        return \Response::json($bitacoras);

	    }

       
    }

