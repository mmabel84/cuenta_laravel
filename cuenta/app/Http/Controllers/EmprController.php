<?php

namespace App\Http\Controllers;

use App\Empresa;
use Illuminate\Http\Request;

class EmprController extends Controller
{
    public function index()
    {       

        $empresa = Empresa::all();

        return view('listaempresa')->with('empresas',$empresa);
    }

    public function save(Request $request)
    {
    	
    	$empresaf = new Empresa;
    	$empresaf->empr_rfc = $request->empr_rfc;
    	$empresaf->empr_nom = $request->empr_nom;
    	$empresaf->empr_razsoc = $request->empr_razsoc;
    	$empresaf->save();

    	return redirect()->route('listempr');



    }

    public function delete($id)
    {
    	
    	$empresad = Empresa::find($id);
    	
    	if ($empresad)
    	{
    		$empresad->delete();
    	}

    	return redirect()->route('listempr');



    }
}
