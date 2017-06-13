<?php

namespace App\Http\Controllers;
use App\User;
use App\BasedatosApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\RegistersUsers;
use View;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\Auth;

class UsrController extends Controller
{
    use RegistersUsers;
    //TODO poner en todos los controladores
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function customvalidator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'users_nick' => 'required|string|max:15|unique:users',
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function customcreate(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'users_nick' => $data['users_nick'],
        ]);
    } 

    public function customregister(Request $request, $values)
    {
        $this->customvalidator($values)->validate();

        event(new Registered($user = $this->customcreate($values)));

        $this->registered($request, $user);

        return $user;
    } 


    public function index()
    {       

        $usuario = User::all();
        $apps = BasedatosApp::all();

        return view('usuarios',['apps'=>$apps,'usuarios'=>$usuario]);

    }

    public function create()
    {       

        $roles = Role::all();
        $permissions = Permission::all();
        $apps = BasedatosApp::all();
        return view('usuariocreate',['apps'=>$apps,'roles'=>$roles,'permissions'=>$permissions]); 

    }

    public function getbdRelated($idusr)
    {       

        $usr = User::find($idusr);
        return $usr->basedatosapps();

    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'users_nick' => 'required|string|users_nick|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    public function relateUsrApp($idusr,$idapp)
    {

        if ($idusr && $idapp)
        {
            $usrp = User::find($idusr);
            $bdp = BasedatosApp::find($idapp);
            $exist = False;
            /*echo "<pre>";
            print_r();die();
            echo "</pre>";*/
            $bdsrelated = $usrp->basedatosapps()->get();

            foreach ($bdsrelated as $bd) {
                if ($bd->id == $idapp){
                    $exist = True;
                }
            }

            if ($exist == True)
            {
                $response = array ('status' => 'Failure', 'result' => "<label  style=' color:#790D4E' class='control-label col-md-12 col-sm-12 col-xs-12'>Ya existe la relación del usuario ".$usrp->name." con base de datos ".$bdp->bdapp_nombd."</label>");
            }
            else
            {
                 $usrp->basedatosapps()->attach($idapp);
                 $response = array ('status' => 'Success', 'result' => '<tr>
                                 <td>' . $bdp->bdapp_nombd . '</td>' .
                                '<td>' . $bdp->bdapp_app . '</td>' .
                                '<td>' . $bdp->empresa->empr_nom . '</td>' .
                                '<td>' . $bdp->empresa->empr_rfc . '</td>' .
                            '</tr>');
            }
        }
       
        return \Response::json($response);
        

    }

    public function verifyUserInBd($uid, $bdid){
        $u = User::find($uid);
        $b = BasedatosApp::find($bdid);
        $exist = false;
        $msg = ', asociado a base de datos de aplicación '.$b->bdapp_nombd;
            foreach ($u->basedatosapps as $bd) {
                if($bd->id == $bdid){
                    $exist = true;
                    $msg = '';
                }
            }
        $result = array ('exist'=>$exist,'msg'=> $msg,'bd'=>$b);

        return $result;
    }

    public function store(Request $request)
    {
       
        $alldata = $request->all();

        $user = $this->customregister($request,$alldata);

        $file     = false;
        if(array_key_exists('users_pic',$alldata)){
            $file     = request()->file('users_pic');
            $path = $request->file('users_pic')->storeAs(
            'public', $user->id.'.'.$file->getClientOriginalName()
        );
        }




        if($file!=false){
            $user->users_pic = $user->id.'.'.$file->getClientOriginalName();
        }

        if(array_key_exists('users_tel',$alldata) && isset($alldata['users_tel'])){
            $user->users_tel = $alldata['users_tel'];
        }

        $user->save();



        if(array_key_exists('roles',$alldata)){
            foreach ($alldata['roles'] as $rol) {
                $rolobj = Role::find($rol);
                $user->attachRole($rolobj);
            }
        }


        if(array_key_exists('permisos',$alldata)){
            foreach ($alldata['permisos'] as $perm) {
                $permobj = Permission::find($perm);
                $user->attachPermission($permobj);
            }
        }


        $fmessage = 'Se ha creado el usuario: '.$alldata['name'];
        \Session::flash('message',$fmessage);
        $this->registroBitacora($request,'create',$fmessage);
        return redirect()->route('usuarios.index'); 







    }

    

    public function edit($id)
    {       

        $user = User::findOrFail($id);
        $roles = Role::all();
        $permissions = Permission::all();


        return view('usuarioedit',['roles'=>$roles,'permissions'=>$permissions,'user'=>$user]); 
    }



    public function update(Request $request, $id)
    {
        /*$usru = User::find($id);
        $usru->name = $request->name;
        $usru->users_tel = $request->users_tel;
        $usru->email = $request->email;
        $usru->users_nick = $request->users_nick;


        $usru->save();
        $msg_update = 'Se ha actualizado el usuario: '.$usru->name;
        
        if ($request->addinstcheck == True){
            $result = $this->verifyUserInBd($usru->id, $request->bdapp_id);
            
            if ($result['exist'] == False){
                $usru->basedatosapps()->attach($request->bdapp_id);
            }
            
            $msg_update = $msg_update.$result['msg'];
        }
        \Session::flash('message',$msg_update);
        return Redirect::to('usuarios');*/

        $alldata = $request->all();
        $user = User::findOrFail($id);

        /*echo "<pre>";
        print_r($alldata);die();
        echo "</pre>";*/

        $file     = false;
        if(array_key_exists('users_pic',$alldata)){
            $file     = request()->file('users_pic');
            $path = $request->file('users_pic')->storeAs(
            'public', $user->id.'.'.$file->getClientOriginalName()
        );
        }else{
            if(array_key_exists('deleted_pic',$alldata)){
                if($alldata['deleted_pic']=='1'){
                    $user->users_pic = 'default_avatar_male.jpg';
                }
            }
        }


        if($file!=false){
            $user->users_pic = $user->id.'.'.$file->getClientOriginalName();
        }

        if(array_key_exists('users_tel',$alldata) && isset($alldata['users_tel'])){
            $user->users_tel = $alldata['users_tel'];
        }


        $user->save();



        if(array_key_exists('roles',$alldata)){
            $user->detachAllRoles();
            foreach ($alldata['roles'] as $rol) {
                $rolobj = Role::find($rol);
                $user->attachRole($rolobj);
            }
        }


        if(array_key_exists('permisos',$alldata)){
            $user->detachAllPermissions();
            foreach ($alldata['permisos'] as $perm) {
                $permobj = Permission::find($perm);
                $user->attachPermission($permobj);

            }
        }





        $fmessage = 'Se ha modificado el usuario: '.$alldata['name'];
        \Session::flash('message',$fmessage);
        $this->registroBitacora($request,'update',$fmessage);
        return redirect()->route('usuarios.index'); 

    }

    

    public function destroy($id, Request $request)
    {
        $user = User::find($id);
        $fmessage = '';
        $messagetype = '';

        if ($user->id == Auth::user()->id){
            $fmessage = 'No es posible eliminar al usuario: '.$user->name.'  autenticado';
            $messagetype = 'failmessage';

        }
        else
        {
            $user->detachAllPermissions();
            $user->detachAllRoles();
            $user->basedatosapps()->detach();
            $fmessage = 'Se ha eliminado el usuario: '.$user->name;
            $messagetype = 'message';
            $this->registroBitacora($request,'delete',$fmessage); 
            $user->delete();

        }
        \Session::flash($messagetype, $fmessage);

        return redirect()->route('usuarios.index'); 


    }


    public function permsbyroles(Request $request)
    {
        $alldata = $request->all();
        $return_array = array();
        if(array_key_exists('selected',$alldata) && isset($alldata['selected'])){
            foreach ($alldata['selected'] as $select) {
                $role = Role::find((int)$select);
                $tests = false;
                if (isset($role)){
                    $tests = $role->permissions()->get();
                    foreach ($tests as $test) {
                        array_push($return_array, $test->id);
                    }
                }


            }
        }

        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
            'roles' => $return_array,
        );
        return \Response::json($response);
    } 

    

}
