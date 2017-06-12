<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;


class RolController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {       

        $roles = Role::all();

        return view('roles')->with('roles',$roles);
    }

    public function create()
    {       

    	$permissions = Permission::all();

        return view('rolcreate')->with('permissions',$permissions);

    }

    public function store(Request $request)
    {

    	$alldata = $request->all();
    	
    	$rol = new Role;
    	$rol->name = $request->name;
    	$rol->slug = $request->slug;
    	$rol->description = $request->description;
    	$rol->level = $request->level;
    	$rol->save();
    	\Session::flash('message','Se ha creado el rol: '.$request->name);

    	if(array_key_exists('permisos',$alldata) && isset($alldata['permisos'])){
    		$permisos = Permission::all();

    		foreach ($alldata['permisos'] as $pid) {
    			$permiso = Permission::find($pid);
    			$rol->attachPermission($permiso);
    		}
        }


    	return redirect()->route('usuarios.index'); 


    }

}
