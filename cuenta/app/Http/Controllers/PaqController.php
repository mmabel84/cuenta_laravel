<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Paquete;

class PaqController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {       

        $paqs = Paquete::all();
        $paqs->sortByDesc('created_at');
        return view('paquetes')->with('paqs',$paqs);
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
