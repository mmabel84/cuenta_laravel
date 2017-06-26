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

class BackController extends Controller
{

	public function index()
    {       

        $backs = Backup::all();

        return view('backups',['backs'=>$backs]);
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

        $msg = 'Respaldo sin ruta en base de datos';
        $status = 'Failure';
        $file = null;

         if ($root == '')
         {
            \Session::flash('failmessage',$msg);
            //$response = array ('status' => $status, 'result' => $msg);
            return Redirect::to('backups');
         }

        $msg = 'Respaldo no encontrado en servidor sftp';
        $status = 'Failure';

            //Funciona pero devuelve el contenido del archivo no legible
        $content = Storage::disk('sftp')->get($root.'.gz');
        if ($content)
        {
            Storage::disk('local')->put($root.'.gz', $content);
            $msg = 'Respaldo descargado exitosamente';
            $status = 'Success';
            //\Session::flash('message',$msg);
            return response()->download(storage_path('app').DIRECTORY_SEPARATOR.$root.'.gz')->deleteFileAfterSend(true);
            
        }

        \Session::flash('failmessage',$msg);
        return Redirect::to('backups');
         
        
        
        
        //->deleteFileAfterSend(true)







    }


    public function create()
    {       
    	$bdapp = BasedatosApp::all();
        return view('backupcreate',['bdapp'=>$bdapp]);
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
    				$fmessage = 'Ha superado el número máximo (5) de respaldos para base de datos '.$dbapp->aplicacion->app_nom. ' de '.$dbapp->empresa->empr_nom.' ,debe eliminar respaldos anteriores para generar nuevos.';
    				\Session::flash('message',$fmessage);
    				return Redirect::to('backups');
    			}
                $carpeta = $dbapp->aplicacion->app_nom.'_'.$dbapp->empresa->empr_rfc;
                $bdname = $dbapp->aplicacion->app_nom.'_'.$dbapp->empresa->empr_rfc.'_'.$backsbd;
                $dest = $carpeta.DIRECTORY_SEPARATOR.$bdname;
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

        $backbd->delete();
        $fmessage = 'Se ha eliminado el respaldo';
        //$fmessage = 'Se ha eliminado el respaldo de aplicación: '.$backbd->aplicacion->app_nom.' de '.$backbd->empresa->empr_nom;
        $this->registroBitacora($request,'delete',$fmessage); 
        \Session::flash('message',$fmessage);

        return Redirect::to('backups');


    }
}
