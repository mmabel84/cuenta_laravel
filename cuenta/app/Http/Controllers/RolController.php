<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use View;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Redirect;


class RolController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {       

        $roles = Role::all();
        \Session::pull('failmessage','default');

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
        $fmessage = 'Se ha creado el rol: '.$request->name;
    	\Session::flash('message',$fmessage);

    	if(array_key_exists('permisos',$alldata) && isset($alldata['permisos'])){
    		$permisos = Permission::all();
    		$allperm = $alldata['permisos'];
    		foreach ($allperm as $pid) {
    			$permiso = Permission::find($pid);
    			$rol->attachPermission($permiso);
    		}
        }
        $this->registroBitacora($request,'create',$fmessage); 


    	return redirect()->route('roles.index'); 


    }

    public function edit($id)
    {       

    	$rol = Role::find($id);
    	$permissions = Permission::all();

    	return view('roledit',['permissions'=>$permissions,'rol'=>$rol]); 

    }

    public function update(Request $request, $id)
    {
    	$rol = Role::find($id);
		$rol->name = $request->name;
        $rol->slug = $request->slug;
        $rol->description = $request->description;
        
        $rol->save();
        $rol->detachAllPermissions();
        $alldata = $request->all();
        if(array_key_exists('permisos',$alldata) && isset($alldata['permisos'])){
            $permisos = Permission::all();
            $allperm = $alldata['permisos'];
            foreach ($allperm as $pid) {
                $permiso = Permission::find($pid);
                $rol->attachPermission($permiso);
            }
        }
        $fmessage = 'Se ha actualizado el rol: '.$request->name;
        $this->registroBitacora($request,'update',$fmessage); 

        \Session::flash('message',$fmessage);
        return Redirect::to('roles');

    }


}
