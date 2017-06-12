<?php

namespace App\Http\Controllers;

use App\BasedatosApp;
use App\User;
use App\Empresa;
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
       return View::make('appcreate')->with('empresas',$empresa);
    }

    public function store(Request $request)
    {
    	$apps = BasedatosApp::all();
    	$emprexist = null;

    	foreach ($apps as $a )
    	{
    		if ($a->bdapp_app == $request->bdapp_app && $a->bdapp_empr_id == $request->bdapp_empr_id)
    		{
    			$emprexist = Empresa::find($a->bdapp_empr_id)->empr_nom;
    		}
    	}

    	
    	if ($emprexist != null)
    	{
	    	\Session::flash('message','Ya existe una base de datos creada de la empresa: '.$emprexist." con la aplicación ".$request->bdapp_app);
	    	return redirect()->route('apps.create');
    	}

    	$app = new BasedatosApp;
    	$empresa = Empresa::find($request->bdapp_empr_id);
    	$app->bdapp_app = $request->bdapp_app;
    	$app->bdapp_empr_id = $request->bdapp_empr_id;
    	$app->bdapp_nomserv = $request->bdapp_nomserv;
    	$app->bdapp_nombd =  $empresa->empr_rfc.'_'.$request->bdapp_app;
    	$app->save();
        //Generar base de datos con script de app en servidor especificado
    	\Session::flash('message','Se ha creado la base de datos de aplicación: '.$empresa->empr_rfc."_".$request->bdapp_app);
    	return Redirect::to('apps');


    }

     public function destroy($id)
    {
        
        $appd = BasedatosApp::find($id);

        $appd->delete();
        \Session::flash('message','Se ha eliminado la base de datos de aplicación: '.$appd->bdapp_nombd);

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
        $appu->bdapp_app = $request->bdapp_app;
        $appu->bdapp_nomserv = $request->bdapp_nomserv;
        $appu->bdapp_empr_id = $request->bdapp_empr_id;
         $appu->bdapp_nombd = $request->bdapp_nombd;
        
        $appu->save();
        \Session::flash('message','Se ha actualizado la base de datos de aplicación: '.$request->bdapp_nombd);
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
                $response = array ('status' => 'Failure', 'result' => "<label  style=' color:#790D4E' class='control-label col-md-12 col-sm-12 col-xs-12'>Ya existe la relación del usuario ".$usrp->name." con base de datos ".$bdp->bdapp_nombd."</label>");
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
