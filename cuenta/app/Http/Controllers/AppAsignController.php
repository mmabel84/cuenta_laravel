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

    public function create()
    {       

       return redirect()->back();
    }

    public function edit()
    {       

       return redirect()->back();
    }

    public function store(Request $request)
    {
    	
    	return redirect()->back();
    }

     public function destroy($id, Request $request)
    {
    	
    	return redirect()->back();
    }
}
