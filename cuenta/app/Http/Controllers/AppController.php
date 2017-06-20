<?php

namespace App\Http\Controllers;

use App\BasedatosApp;
use App\User;
use App\Empresa;
use App\Aplicacion;
use Illuminate\Http\Request;
use View;
use Illuminate\Support\Facades\Redirect;

class AppController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

     public function index()
    {       
        $usrs = User::all();
        $apps = BasedatosApp::all();

        return view('apps',['apps'=>$apps,'usrs'=>$usrs]);
    }

    public function create()
    {       


    	$empresa = Empresa::all();
        $aplicaciones = Aplicacion::all();
        return view('appcreate',['empresas'=>$empresa,'aplicaciones'=>$aplicaciones]);
    }

    public function store(Request $request)
    {
    	$bdapps = BasedatosApp::all();
    	$emprexist = null;
        $appexist = null;

    	foreach ($bdapps as $a )
    	{
    		if ($a->bdapp_app_id == $request->bdapp_app_id && $a->bdapp_empr_id == $request->bdapp_empr_id)
    		{
    			$emprexist = Empresa::find($a->bdapp_empr_id)->empr_nom;
                $appexist = Aplicacion::find($a->bdapp_app_id)->app_nom;

    		}
    	}
    	
    	if ($emprexist != null)
    	{
	    	\Session::flash('message','Ya existe una base de datos creada de la empresa: '.$emprexist." con la aplicación ".$appexist);
	    	return redirect()->route('apps.create');
    	}

    	$appbd = new BasedatosApp;
    	$empresa = Empresa::find($request->bdapp_empr_id);
        $app = Aplicacion::find($request->bdapp_app_id);


    	$appbd->bdapp_app_id = $request->bdapp_app_id;
        $appbd->bdapp_app = $app->app_cod;
    	$appbd->bdapp_empr_id = $request->bdapp_empr_id;
        //llamar archivo de configuracion para seleccionar base de datos
    	$appbd->bdapp_nomserv = 'Test';
    	$appbd->bdapp_nombd =  $empresa->empr_rfc.'_'.$app->app_cod;
    	$appbd->save();

        //Generar base de datos con script de app en servidor especificado
        $fmessage = 'Se ha creado la base de datos de aplicación: '.$empresa->empr_rfc."_".$app->app_cod;
        $this->registroBitacora($request,'create',$fmessage); 
    	\Session::flash('message',$fmessage);
    	return Redirect::to('apps');


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


    public function edit($id)
    {       

        $empresa = Empresa::all();

        $appe = BasedatosApp::find($id);
        return view('appedit',['app'=>$appe,'empresas'=>$empresa]);
    }

    public function update(Request $request, $id)
    {
        $appu = BasedatosApp::find($id);
        $app = Aplicacion::where('app_cod', '=', $request->bdapp_app)->get();



        $appu->bdapp_app_id =  $app[0]->id;
        $appu->bdapp_app = $app[0]->app_cod;
        //llamar archivo de configuracion para seleccionar base de datos
        $appu->bdapp_nomserv = 'Test';
        $appu->bdapp_empr_id = $request->bdapp_empr_id;
        
        
        $appu->save();
        $fmessage = 'Se ha actualizado la aplicación: '.$app[0]->app_nom.', de la empresa: '.$appu->empresa->empr_nom;
        $this->registroBitacora($request,'update',$fmessage); 
        \Session::flash('message',$fmessage);
        return Redirect::to('apps');

    }

    public function relateAppUsr($idapp,$idusr)
    {

        if ($idusr && $idapp)
        {
            $usrp = User::find($idusr);
            $bdp = BasedatosApp::find($idapp);
            $exist = False;
            $usrrelated = $bdp->users()->get();

            foreach ($usrrelated as $u) {
                if ($u->id == $idusr){
                    $exist = True;
                }
            }

            if ($exist == True)
            {
                $response = array ('status' => 'Failure', 'result' => "<label  style=' color:#790D4E' class='control-label col-md-12 col-sm-12 col-xs-12'>Ya existe la relación con el usuario ".$usrp->name."</label>");
            }
            else
            {
                 $bdp->users()->attach($idusr);
                 $response = array ('status' => 'Success', 'result' => '<tr>
                                 <td>' . $usrp->name . '</td>' .
                                '<td>' . $usrp->email . '</td>' .
                                '<td>' . $usrp->users_tel . '</td>' .
                            '</tr>');
            }
        }
       
        return \Response::json($response);
        

    }

}
