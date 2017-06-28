<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Aplicacion;
use App\Paquete;
use App\User;


class ServController extends Controller
{
    public function createbd(Request $request)
    {
        $alldata = $request->all();
        $msg = "Base de datos creada satisfactoriamente.";
        $status = "Success";

        if(array_key_exists('rfc_nombrebd',$alldata) && isset($alldata['rfc_nombrebd'])){
            
            $dbname = $alldata['rfc_nombrebd'].'_'.$alldata['account_id'];
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

		        // Desplegando en cuenta las aplicaciones y paquete contratados en control
		        
		       if(array_key_exists('apps_cta',$alldata) && isset($alldata['apps_cta'])){

		        	$apps = json_decode($alldata['apps_cta']);
		        	
		        	foreach ($apps as $appc) {
		        		DB::connection($dbname)->insert('insert into app (app_nom, app_cod, created_at) values (?, ?, ?)', [$appc->app_nom, $appc->app_cod, date('Y-m-d H:i:s')]);
		        	}

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

	   public function addapp(Request $request){

	   		$alldata = $request->all();
	        $msg = "Aplicación añadida.";
	        $status = "Success";

	        if(array_key_exists('apps_cta',$alldata) && isset($alldata['apps_cta']) && array_key_exists('rfc_nombrebd',$alldata) && isset($alldata['rfc_nombrebd']) && array_key_exists('account_id',$alldata) && isset($alldata['account_id'])){

	        	$apps = json_decode($alldata['apps_cta']);
	        	$dbname = $alldata['rfc_nombrebd'];
	            $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?";
	            $db = DB::select($query, [$dbname]);
		        

		        if(!empty($db)){

		        	foreach ($apps as $appc) {
		        		DB::connection($dbname)->insert('insert into app (app_nom, app_cod, created_at) values (?, ?, ?)', [$appc->app_nom, $appc->app_cod, date('Y-m-d H:i:s')]);
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
	        	$dbname = $alldata['rfc_nombrebd'];
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

       
    }

