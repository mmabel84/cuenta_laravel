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
        \Session::pull('failmessage','default');

        return view('paquetes')->with('paqs',$paqs);
    }

}
