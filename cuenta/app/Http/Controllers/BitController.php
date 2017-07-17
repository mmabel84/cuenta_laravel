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
        \Session::pull('failmessage','default');

        return view('bitacoras')->with('bitacoras',$bitacoras);
    }

}
