<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\BasedatosApp;
use App\Backup;
use Auth;
use View;
use Illuminate\Support\Facades\Redirect;

class BackController extends Controller
{

	public function index()
    {       

        $backs = Backup::all();

        return view('backups',['backs'=>$backs]);
    }

    public function downloadBackup(){
    	$download = DB::table('backbd')->get();
    	return view('backups',compact($download));

    }

    public function executeBackup(Request $request){

    	$alldata = $request->all();
    	$bd = $alldata['nom_bd'];
    	$destination = 'sftp';
    	
    	
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
    			$backbd->backbd_linkback = '';
    			$backbd->backbd_user = Auth::user()->name;

    			$backsbd = count(Backup::where('backbd_bdapp_id', '=', $dbid)->get()) + 1;

    			$fmessage = 'Se ha generado el respaldo número '. $backsbd .' de aplicación '.$dbapp->aplicacion->app_nom. ' de '.$dbapp->empresa->empr_nom;
    			//Límite de respaldos de 5
    			if ($backsbd == 6){
    				$fmessage = 'Ha superado el número máximo (5) de respaldos para base de datos '.$dbapp->aplicacion->app_nom. ' de '.$dbapp->empresa->empr_nom.' ,debe eliminar respaldos anteriores para generar nuevos.';
    				\Session::flash('message',$fmessage);
    				return Redirect::to('backups');
    			}

    			\Artisan::call('db:backup', array('--destination' => 'sftp', '--database'=> 'mysql', '--destinationPath' => '/opt/bitnami/apache2/htdocs/mabel/test2', '--compression' => 'gzip')) ;

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
        
        $appd = BasedatosApp::find($id);
        $appd->users()->detach();
        $appd-> backups()->delete();

        $appd->delete();
        $fmessage = 'Se ha eliminado la base de datos de aplicación: '.$appd->bdapp_nombd;
        $this->registroBitacora($request,'delete',$fmessage); 
        \Session::flash('message',$fmessage);

        return Redirect::to('apps');


    }
}
