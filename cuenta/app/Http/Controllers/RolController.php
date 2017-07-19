<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use View;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Auth\Events\Registered;
use Bican\Roles\Traits\HasRoleAndPermission;


class RolController extends Controller
{
    use HasRoleAndPermission;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {     
        $usr = $user = \Auth::user();
        if ($usr->can('leer.rol'))  
        {
            $roles = Role::all();
            return view('roles')->with('roles',$roles);
        }
        \Session::flash('failmessage','No tiene acceso a leer roles');
        return redirect()->back();
    }

    public function create()
    {       
        $usr = $user = \Auth::user();
        if ($usr->can('crear.rol'))  
        {
            $permissions = Permission::all();
            return view('rolcreate')->with('permissions',$permissions);
        }
        \Session::flash('failmessage','No tiene acceso a crear roles');
        return redirect()->back();
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

        $usr = $user = \Auth::user();
        if ($usr->can('editar.rol'))  
        {
            $rol = Role::find($id);
            $permissions_related = $rol->permissions()->get()->pluck('id');

            /*echo "<pre>";
            print_r($permissions_related); die();
            echo "</pre>";*/
            $permissions = Permission::all();
            return view('roledit',['permissions'=>$permissions,'rol'=>$rol,'permissions_related'=>json_encode($permissions_related)]); 
        }  
        \Session::flash('failmessage','No tiene acceso a editar roles');
        return redirect()->back();
    	

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

    public function destroy($id, Request $request)
    {
        
        return redirect()->back();
    }


}
