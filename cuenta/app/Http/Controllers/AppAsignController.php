<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aplicacion;
use View;
use Illuminate\Support\Facades\Redirect;

class AppAsignController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {       

        $aplicaciones = Aplicacion::all();

        return view('appsasign')->with('apps',$aplicaciones);
    }

    /*public function create()
    {       

       return View::make('appsasigncreate');
    }

    public function store(Request $request)
    {
    	
    	$app = new Aplicacion;
    	$app->app_nom = $request->app_nom;
    	$app->app_cod = $request->app_cod;
    	$app->save();
    	return Redirect::to('appsasign');


    }

     public function destroy($id, Request $request)
    {
    	
    	$app = Aplicacion::find($id);
       
        $app->delete();
           
 	   	return Redirect::to('appsasign');


    }*/
}
