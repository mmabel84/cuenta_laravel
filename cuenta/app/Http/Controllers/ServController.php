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
            
            $dbname = $alldata['rfc_nombrebd'];
            $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?";
	        $db = DB::select($query, [$dbname]);

	        
	        if(empty($db)){
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
		        $strfile=file_get_contents(base_path() .'/config/database.php');
		        $strfile=str_replace("//AddDB", $str_to_replace, $strfile);
		        file_put_contents(base_path() .'/config/database.php', $strfile);
		        \Config::set('database.default', $dbname);
		        \Artisan::call('migrate');

		        //Creando usuario para primera conexión a cuenta TODO: poner datos de usuario correctos
		       $usr = new User;
		        $usr->name = 'Test';
		        $usr->email = 'test@gmail.com';
		        $usr->users_nick = 'test';
		        $usr->password = bcrypt('test');
		        $usr->save();

		        // Desplegando en cuenta las aplicaciones y paquete contratados en control
		        
		       /* if(array_key_exists('apps_cta',$alldata) && isset($alldata['apps_cta'])){

		        	foreach ($alldata['apps_cta'] => $appc) {
		        		$app = new Aplicacion;
		        		$app->app_nom = $appc['app_nom'];
				    	$app->app_cod = $appc['app_cod'];
				    	$app->save();
		        	}

		        	foreach ($alldata['paq_cta'] => $paqt) {
		        		$paq = new Paquete;
		        		$paq->paqapp_cantrfc = $paqt['paqapp_cantrfc'];
				    	$paq->paqapp_cantgig = $paqt['paqapp_cantgig'];
				    	$paq->paqapp_f_venta = $paqt['paqapp_f_venta'];
				    	$paq->paqapp_f_act = $paqt['paqapp_f_act'];
				    	$paq->paqapp_f_fin = $paqt['paqapp_f_fin'];
				    	$paq->paqapp_f_caduc = $paqt['paqapp_f_caduc'];
				    	$paq->paqapp_control_id = $paqt['paqapp_control_id'];
				    	$paq->save();
		        	}

		        }*/

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

	   /*public function desactpaq(Request $request){

	   		return true;
	   }*/

       
    }

