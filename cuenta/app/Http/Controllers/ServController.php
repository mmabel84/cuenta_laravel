<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServController extends Controller
{
    public function createbd(Request $request)
    {
        $alldata = $request->all();

        $dbname = "testdba";
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
        \Config::set('database.default', \Session::get('selected_database','mysql'));



        $response = array(
            'status' => 'success',
            'msg' => 'Se cambió la contraseña satisfactoriamente',
            'user' => $alldata,
        );
        return \Response::json($response);
    }
}
