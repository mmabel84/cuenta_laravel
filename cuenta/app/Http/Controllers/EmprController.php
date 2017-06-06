<?php

namespace App\Http\Controllers;


use App\Empresa;
use App\BasedatosApp;
use App\User;
use Illuminate\Http\Request;
use View;
use Illuminate\Support\Facades\Redirect;

class EmprController extends Controller
{
    public function index()
    {       

        $empresa = Empresa::all();

        return view('empresas')->with('empresas',$empresa);
    }

    public function create()
    {       

       return View::make('empresacreate');
    }

    public function edit($id)
    {       

    	$empresase = Empresa::find($id);
    	return View::make('empresaedit')
            ->with('empresa', $empresase);
    }

    public function update(Request $request, $id)
    {
    	$empresau = Empresa::find($id);
		$empresau->empr_nom = $request->empr_nom;
        $empresau->empr_rfc = $request->empr_rfc;
        $empresau->empr_razsoc = $request->empr_razsoc;
        
        $empresau->save();
        \Session::flash('message','Se ha actualizado la empresa: '.$request->empr_nom);
        return Redirect::to('empresas');

    }

    

    public function store(Request $request)
    {
    	
    	$empresaf = new Empresa;
    	$empresaf->empr_rfc = $request->empr_rfc;
    	$empresaf->empr_nom = $request->empr_nom;
    	$empresaf->empr_razsoc = $request->empr_razsoc;
    	$empresaf->save();
    	\Session::flash('message','Se ha creado la empresa: '.$request->empr_nom);
    	return Redirect::to('empresas');


    }

    public function destroy($id)
    {
    	
    	$empresad = Empresa::find($id);
        $apps = BasedatosApp::where('bdapp_empr_id', '=', $id)->get();



        if (count($apps) == 0)
        {
            $empresad->delete();
            \Session::flash('message','Se ha eliminado la empresa: '.$empresad->empr_nom);
        }
        else{

            \Session::flash('failmessage','No se puede eliminar la empresa: '.$empresad->empr_nom. ' mientras existan bases de datos de aplicación dependientes');
        }

 	   	return Redirect::to('empresas');


    }

        
}
