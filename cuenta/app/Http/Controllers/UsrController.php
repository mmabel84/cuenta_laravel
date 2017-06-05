<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use View;

class UsrController extends Controller
{
    public function index()
    {       

        $usuario = User::all();

        return view('usuarios')->with('usuarios',$usuario);
    }

    public function create()
    {       

       return View::make('usuariocreate');
    }

}
