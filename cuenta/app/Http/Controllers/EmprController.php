<?php

namespace App\Http\Controllers;


use App\Empresa;
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

    	$empresae = Empresa::find($id);

      	return view('empresa');
    }

    

    public function store(Request $request)
    {
    	
    	$empresaf = new Empresa;
    	$empresaf->empr_rfc = $request->empr_rfc;
    	$empresaf->empr_nom = $request->empr_nom;
    	$empresaf->empr_razsoc = $request->empr_razsoc;
    	$empresaf->save();
    	return Redirect::to('empresas');


    }

    public function destroy($id)
    {
    	
    	$empresad = Empresa::find($id);
    	
    	if ($empresad)
    	{
    		$empresad->delete();
    	}

    	return Redirect::to('empresas');


    }

    
}
