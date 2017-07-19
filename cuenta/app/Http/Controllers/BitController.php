<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bitacora;

class BitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {       

        $bitacoras = Bitacora::all();
        return view('bitacoras')->with('bitacoras',$bitacoras);
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
