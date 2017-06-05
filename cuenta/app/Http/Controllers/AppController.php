<?php

namespace App\Http\Controllers;

use App\BasedatosApp;
use App\Empresa;
use Illuminate\Http\Request;
use View;
use Illuminate\Support\Facades\Redirect;

class AppController extends Controller
{
     public function index()
    {       

        $app = BasedatosApp::all();


        return view('apps')->with('apps',$app);
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
    	\Session::flash('message','Se ha creado la base de datos de aplicación: '.$empresa->empr_rfc."_".$request->bdapp_app);
    	return Redirect::to('apps');


    }
}
