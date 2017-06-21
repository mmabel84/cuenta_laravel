<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BackController extends Controller
{

	public function index()
    {       

        $download = DB::table('backbd')->get();
        return view('backups')->with('backs',compact($download));
    }

    public function downloadBackup(){
    	$download = DB::table('backbd')->get();
    	return view('backups',compact($download));

    }

    public function executeBackup(Request $request){

    	$alldata = $request->all();
    	$bd = $alldata['nom_bd'];
    	$destination = 'sftp';
    	
    	Artisan::call('bd:backup', ['database'=> $bd, 'destinarion' => $destination, 'destinationPath' => '', 'compression' => 'gzip']]);

    }
}
