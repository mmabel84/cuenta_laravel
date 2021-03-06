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

        $msg = 'Respaldo sin ruta almacenada';
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
    		$fmessage = 'No aplica la acción de generar respaldo para solución seleccionada';

    		if ($dbapp){
                $gener_inst = config('app.advans_apps_gener_inst.'.$dbapp->bdapp_app);
                if ($dbapp->bdapp_app != 'fact')
                {
                    $backbd = new Backup;
                    $backbd->backbd_fecha = date('Y/m/d H:i:s');
                    $backbd->backbd_bdapp_id = $dbid;
                    $backbd->backbd_user = Auth::user()->name;

                    $backsbd = count(Backup::where('backbd_bdapp_id', '=', $dbid)->get()) + 1;

                    $fmessage = 'Se ha generado el respaldo número '. $backsbd .' de solución de aplicación '.$dbapp->aplicacion->app_nom. ' de empresa '.$dbapp->empresa->empr_nom;
                    //Límite de respaldos de 5
                    if ($backsbd == 6){
                        $fmessage = 'Ha superado el número máximo (5) de respaldos para solución de aplicación '.$dbapp->aplicacion->app_nom. ' de empresa '.$dbapp->empresa->empr_nom.', debe eliminar respaldos anteriores para generar nuevos.';
                        \Session::flash('failmessage',$fmessage);
                        return Redirect::to('backups');
                    }
                    $carpeta = $dbapp->aplicacion->app_nom.'_'.$dbapp->empresa->empr_rfc;
                    $bdname = $dbapp->aplicacion->app_nom.'_'.$dbapp->empresa->empr_rfc.'_'.$backsbd;
                    $dest = $carpeta.DIRECTORY_SEPARATOR.$bdname.'_'.date('Y-m-d H:i:s');
                    $backbd->backbd_linkback = $dest;
                    $backbd->backbd_number = $backsbd;

                    if (array_key_exists('backbd_coment',$alldata) && isset($alldata['backbd_coment']))
                    {
                         $backbd->backbd_coment = $alldata['backbd_coment'];
                    }

                    $arrayparams['dbname'] = $dbapp->bdapp_nombd;
                    $arrayparams['dest'] = $dest;
                    $acces_vars = $this->getAccessToken($dbapp->bdapp_app);
                    $service_response = $this->getAppService($acces_vars['access_token'],'createbackp',$arrayparams,$dbapp->bdapp_app);


                    //\Artisan::call('db:backup', array('--destination' => 'sftp', '--database'=> 'MERM840926RY3_cta', '--destinationPath' => $dest, '--compression' => 'gzip')) ;

                    $backbd->save();
                    $this->registroBitacora($request,'create',$fmessage); 

                }
    		}
    	}
    	
    	//Generar base de datos con script de app en servidor especificado
       
        
    	\Session::flash('message',$fmessage);
    	return Redirect::to('backups');
    }

    public function restore($bdid, Request $request)
    {
        Log::info('entre a restaurar');
        if($bdid){
            $backup = Backup::find($bdid);
            $fmessage = 'Respaldo no encontrado';

            if ($backup){

                $dest = $backup->backbd_linkback;
                $dbapp = $backup->basedatosapp;

                Log::info($dest);

                $fmessage = 'Se ha restaurado el respaldo número '. $backup->backbd_number .' de solución de aplicación '.$dbapp->aplicacion->app_nom. ' de empresa '.$dbapp->empresa->empr_nom;
                //Límite de respaldos de 5
                
                $arrayparams['dbname'] = $dbapp->bdapp_nombd;
                $arrayparams['dest'] = $dest;
                $acces_vars = $this->getAccessToken($dbapp->bdapp_app);
                $service_response = $this->getAppService($acces_vars['access_token'],'restorebackp',$arrayparams,$dbapp->bdapp_app);

                Log::info($service_response['status']);
                $backup->backbd_respaldado = true;
                $backup->backbd_f_respaldo = date('Y-m-d H:i:s');
                $backup->save();

                $this->registroBitacora($request,'restore backup',$fmessage); 
            }
        }
        
        //Generar base de datos con script de app en servidor especificado
       
        
        \Session::flash('message',$fmessage);
        return Redirect::to('backups');

    }

     public function destroy($id, Request $request)
    {
                
        $backbd = Backup::find($id);
        $root = $backbd->backbd_linkback;

        Storage::disk('sftp')->delete($root.'.gz');
        $fmessage = 'Se ha eliminado respaldo de solución de aplicación '.$backbd->basedatosapp->aplicacion->app_nom.' de empresa '.$backbd->basedatosapp->empresa->empr_nom;
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
