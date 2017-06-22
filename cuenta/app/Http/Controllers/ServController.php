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

		        $dbtest = config('database.connections.'.$dbname);
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

		        DB::connection($dbname)->insert('insert into users (name, users_nick, email, password) values (?, ?, ?, ?)', ['Test', 'test','test@gmail.com', bcrypt('test')]);

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
            'user' => $alldata,
            'dbvalue' => $dbvalue,
            'exist' => $dbtest);

        	return \Response::json($response);
	       
	   }

	   /*public function desactpaq(Request $request){

	   		return true;
	   }*/

       
    }

