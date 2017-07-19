<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use View;
use Illuminate\Foundation\Auth\User;

class PermController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {    
        $usr = $user = \Auth::user();
        if ($usr->can('leer.permiso'))
        {
            $permissions = Permission::all();
            return view('permissions')->with('permissions',$permissions);
        }  
        \Session::flash('failmessage','No tiene acceso a leer permisos');
        return redirect()->back(); 

        
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

    public function destroy()
    {       

        return redirect()->back(); 

    }

}
