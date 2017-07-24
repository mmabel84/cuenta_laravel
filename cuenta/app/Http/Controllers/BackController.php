<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\BasedatosApp;
use App\Backup;
use Auth;
use View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage; 
use BackupManager\Filesystems\SftpFilesystem;
use BackupManager\Filesystems\FilesystemProvider;
use BackupManager\Config\Config;
use Illuminate\Support\Facades\Log;

use phpseclib\Crypt\RSA;
use phpseclib\Net\SFTP;

class BackController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

	public function index()
    {       

        $usr = $user = \Auth::user();
        if ($usr->can('leer.respaldo'))
        {
            $backs = Backup::all();

            return view('backups',['backs'=>$backs]);
        }

        \Session::flash('failmessage','No tiene acceso a leer respaldos');
        return redirect()->back();

        
    }

    public function downloadBackup($bdid){
    	 
        // $fs = Storage::disk('sftp')->getDriver();
        // $stream = $fs->readStream($dest);
        $root = '';

        if ($bdid){

            $backapp = Backup::find($bdid);
            if($backapp){
                $root = $backapp->backbd_linkback;
            }
        }
        Log::info($bdid);
        Log::info($root);

        $msg = 'Respaldo sin ruta en base de datos';
        $status = 'Failure';
        $file = null;

         if ($root == '')
         {
            \Session::flash('failmessage',$msg);
            return Redirect::to('backups');
         }

        $msg = 'Respaldo no encontrado en servidor sftp';
        $status = 'Failure';

        $content = Storage::disk('sftp')->get($root.'.gz');

        if ($content)
        {
            Storage::disk('local')->put($root.'.gz', $content);
            $msg = 'Respaldo descargado exitosamente';
            $status = 'Success';
            return response()->download(storage_path('app').DIRECTORY_SEPARATOR.$root.'.gz')->deleteFileAfterSend(true);//
            
        }


        \Session::flash('failmessage',$msg);
        return Redirect::to('backups');
         
        //->deleteFileAfterSend(true)

    }


    public function create()
    {       
        $usr = $user = \Auth::user();
        if ($usr->can('crear.respaldo'))
        {
            $bdapp = BasedatosApp::all();
            return view('backupcreate',['bdapp'=>$bdapp]);

        }
        
        \Session::flash('failmessage','No tiene acceso a crear respaldos');
        return redirect()->back();




        /*$sftp = new SFTP('13.58.170.3');

        $Key = new RSA();
        // If the private key has a passphrase we set that first
        $Key->setPassword('Advan$97120');
        // Next load the private key using file_gets_contents to retrieve the key
        $Key->loadKey(Storage::disk('local')->get('dev-boveda.ppk'));

        if (!$sftp->login('bitnami', $Key)) {
            throw new Exception('Login failed');
        }*/
        
    }

    public function store(Request $request)
    {
    	$alldata = $request->all();

    	if(array_key_exists('bdapp_app_id',$alldata) && isset($alldata['bdapp_app_id'])){
    		$dbid = $alldata['bdapp_app_id'];
    		$dbapp = BasedatosApp::find($dbid);
    		$fmessage = '';

    		if ($dbapp){
    			//TODO Llamar a servcio de app específica pasando nombre de bd ($dbapp->bdapp_nombd), tomando como respuesta url de backup generado
    			
    			$backbd = new Backup;
    			$backbd->backbd_fecha = date('Y/m/d H:i:s');
    			$backbd->backbd_bdapp_id = $dbid;
    			$backbd->backbd_user = Auth::user()->name;

    			$backsbd = count(Backup::where('backbd_bdapp_id', '=', $dbid)->get()) + 1;

    			$fmessage = 'Se ha generado el respaldo número '. $backsbd .' de aplicación '.$dbapp->aplicacion->app_nom. ' de '.$dbapp->empresa->empr_nom;
    			//Límite de respaldos de 5
    			if ($backsbd == 6){
    				$fmessage = 'Ha superado el número máximo (5) de respaldos para base de datos '.$dbapp->aplicacion->app_nom. ' de '.$dbapp->empresa->empr_nom.', debe eliminar respaldos anteriores para generar nuevos.';
    				\Session::flash('failmessage',$fmessage);
    				return Redirect::to('backups');
    			}
                $carpeta = $dbapp->aplicacion->app_nom.'_'.$dbapp->empresa->empr_rfc;
                $bdname = $dbapp->aplicacion->app_nom.'_'.$dbapp->empresa->empr_rfc.'_'.$backsbd;
                $dest = $carpeta.DIRECTORY_SEPARATOR.$bdname.'_'.date('Y-m-d H:i:s');
                $backbd->backbd_linkback = $dest;

    			\Artisan::call('db:backup', array('--destination' => 'sftp', '--database'=> 'mysql', '--destinationPath' => $dest, '--compression' => 'gzip')) ;

    			$backbd->save();

    			
    		}
    	}
    	
    	//Generar base de datos con script de app en servidor especificado
       
        $this->registroBitacora($request,'create',$fmessage); 
    	\Session::flash('message',$fmessage);
    	return Redirect::to('backups');
    }

     public function destroy($id, Request $request)
    {
                
        $backbd = Backup::find($id);
        $root = $backbd->backbd_linkback;

        Storage::disk('sftp')->delete($root.'.gz');
        $fmessage = 'Se ha eliminado respaldo de aplicación '.$backbd->basedatosapp->aplicacion->app_nom.' de empresa '.$backbd->basedatosapp->empresa->empr_nom;
        $backbd->delete();
        
        //$fmessage = 'Se ha eliminado el respaldo de aplicación: '.$backbd->aplicacion->app_nom.' de '.$backbd->empresa->empr_nom;
        $this->registroBitacora($request,'delete',$fmessage); 
        \Session::flash('message',$fmessage);

        return Redirect::to('backups');


    }

    public function edit()
    {       

       return redirect()->back();
    }
}
