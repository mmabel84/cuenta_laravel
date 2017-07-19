<?php

namespace App\Http\Controllers;


use App\Empresa;
use App\BasedatosApp;
use App\User;
use App\Paquete;
use Illuminate\Http\Request;
use View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class EmprController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {       
        $usr = $user = \Auth::user();
        if ($usr->can('leer.empresa'))
        {
            $empresa = Empresa::all();
            return view('empresas')->with('empresas',$empresa);
        }
        \Session::flash('failmessage','No tiene acceso a leer empresas');
        return redirect()->back();

        
    }

    public function create()
    {       

        $usr = $user = \Auth::user();
        if ($usr->can('crear.empresa'))
        {
            $totalempscreadas = Empresa::all();
            $totalpaquetesact = Paquete::where('paqapp_activo', '=', true)->get();
            $totalempcont = 0;

            foreach ($totalpaquetesact as $paq) {
                $totalempcont+=$paq->paqapp_cantrfc;
            }

           return View::make('empresacreate');
        }
        \Session::flash('failmessage','No tiene acceso a crear empresas');
        return redirect()->back();
        
    }

    public function edit($id)
    {    
        $usr = $user = \Auth::user();
        if ($usr->can('editar.empresa'))
        { 
            $empresase = Empresa::find($id);
            return View::make('empresaedit')
            ->with('empresa', $empresase);
        }
        \Session::flash('failmessage','No tiene acceso a editar empresas');
        return redirect()->back();
    } 

    	

    public function update(Request $request, $id)
    {
    	$input = $request->all();
        $rules = ['empr_rfc' => 'required|rfc'];
        $messages = ['rfc' => 'RFC inválido'];

        $validator = Validator::make($input, $rules, $messages)->validate();



        $empresau = Empresa::find($id);
		$empresau->empr_nom = $request->empr_nom;
        $empresau->empr_rfc = $request->empr_rfc;
        $empresau->empr_razsoc = $request->empr_razsoc;
        
        $empresau->save();
        $fmessage = 'Se ha actualizado la empresa: '.$request->empr_nom;
        $this->registroBitacora($request,'update',$fmessage); 
        \Session::flash('message',$fmessage);
        return Redirect::to('empresas');

    }

    

    public function store(Request $request)
    {
    	
    	
        $input = $request->all();
        $rules = ['empr_rfc' => 'required|rfc'];
        $messages = ['rfc' => 'RFC inválido'];

        $validator = Validator::make($input, $rules, $messages)->validate();
        
        /*$this->validate($request, [
            'empr_rfc' => 'required|rfc',
        ]);*/

        $empresaf = new Empresa;
    	$empresaf->empr_rfc = strtoupper($request->empr_rfc);
    	$empresaf->empr_nom = $request->empr_nom;
    	$empresaf->empr_razsoc = $request->empr_razsoc;
    	$empresaf->save();
        $fmessage = 'Se ha creado la empresa: '.$request->empr_nom;
        $this->registroBitacora($request,'create',$fmessage); 
    	\Session::flash('message',$fmessage);
    	return Redirect::to('empresas');


    }

    public function destroy($id, Request $request)
    {
    	
    	$empresad = Empresa::find($id);
        $apps = BasedatosApp::where('bdapp_empr_id', '=', $id)->get();
        $fmessage = 'Se ha eliminado la empresa: '.$empresad->empr_nom;


        if (count($apps) == 0)
        {
            $empresad->delete();
            $this->registroBitacora($request,'delete',$fmessage); 
            \Session::flash('message',$fmessage);
        }
        else{
            $fmessage = 'No se puede eliminar la empresa: '.$empresad->empr_nom. ' mientras existan bases de datos de aplicación dependientes';
            \Session::flash('failmessage',$fmessage);
        }

 	   	return Redirect::to('empresas');


    }



    function valid_rfc_fisica($str) {
        if (in_array($str, array('XAXX010101000', 'XEXX010101000'))) {
            return true;
        }
        $result = preg_match('/^[A-ZÑ&]{4}([0-9]{2})([0-1][0-9])([0-3][0-9])[A-Z0-9][A-Z0-9][0-9A]$/u', $str, $matches);
        if (!$result) {
            return false;
        }
        if ((int) $matches[1] <= 12) {
            $matches[1] = 2000 + (int) $matches[1];
        } else {
            $matches[1] = 1900 + (int) $matches[1];
        }
        return strtotime($matches[1] . '-' . $matches[2] . '-' . $matches[3]) ? true : false;
    }
    
    function valid_rfc_moral($str) {
        $result = preg_match('/^[A-ZÑ&]{3}([0-9]{2})([0-1][0-9])([0-3][0-9])[A-Z0-9][A-Z0-9][0-9A]$/u', $str, $matches);
        if (!$result) {
            return false;
        }
        if ((int) $matches[1] <= 12) {
            $matches[1] = 2000 + (int) $matches[1];
        } else {
            $matches[1] = 1900 + (int) $matches[1];
        }
        return strtotime($matches[1] . '-' . $matches[2] . '-' . $matches[3]) ? true : false;
    }
    
    function valid_rfc($str) {
        return $this->valid_rfc_fisica($str) || $this->valid_rfc_moral($str);
    }


        
}
