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

        $permissions = Permission::all();

        return view('permissions')->with('permissions',$permissions);
    }

    public function create()
    {       

        return view('permcreate');

    }

    public function store(Request $request)
    {

    	$alldata = $request->all();
    	
    	$perm = new Permission;
    	$perm->name = $request->name;
    	$perm->slug = $request->slug;
    	$perm->description = $request->description;
    	$perm->save();
    	\Session::flash('message','Se ha creado el permiso: '.$request->name);

    	return redirect()->route('permisos.index'); 


    }
}
