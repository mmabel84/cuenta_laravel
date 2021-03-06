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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Mail\UsrEmail;

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
            'password' => 'required|string|min:8|confirmed|passwordsat',
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
            'password' => bcrypt($data['password'])
        ]);
    } 

    public function customregister(Request $request, $values)
    {
        $this->customvalidator($values)->validate();

        event(new Registered($user = $this->customcreate($values)));

        $this->registered($request, $user);

        $password = $values['password'];
        $email = $values['email'];

        $ctalink = config('app.advans_apps_url.cuenta');
        if (!$ctalink)
        {
            $ctalink = 'http://appcuenta.advans.mx';
        }
        $ctarfc = \Session::get('ctarfc');
        
        if ($user->email && $ctarfc){
            \Mail::to($user->email)->send(new UsrEmail(['ctarfc'=>$ctarfc,'user'=>$email,'password'=>$password,'url'=>$ctalink]));
        }

        return $user;
    } 


    public function index()
    {       
        $usr = $user = \Auth::user();
        if ($usr->can('leer.usuario'))
        {
            $usuarios = User::where('users_control','<>',true)->get();
            /*if ($usr->can('leer.usuario.advans'))
            {
                $usuarios = User::all();
            }*/
            
            $apps = BasedatosApp::all();
            return view('usuarios',['apps'=>$apps,'usuarios'=>$usuarios]);
        }

        \Session::flash('failmessage','No tiene acceso a leer usuarios');
        return redirect()->back();

        

    }

    public function create()
    {       
        $usr = $user = \Auth::user();
        if ($usr->can('crear.usuario'))
        {
            $roles = Role::all();
            $permissions = Permission::all();
            $apps = BasedatosApp::all();
            return view('usuariocreate',['apps'=>$apps,'roles'=>$roles,'permissions'=>$permissions]); 

        }
        \Session::flash('failmessage','No tiene acceso a crear usuarios');
        return redirect()->back();
        

    }

    public function getbdRelated($idusr)
    {       

        $usr = User::find($idusr);
        return $usr->basedatosapps();

    }

    /*protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'users_nick' => 'required|string|users_nick|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }*/

    public function relateUsrApp(Request $request)
    {
        $alldata = $request->all();

        if(array_key_exists('usrid',$alldata) && isset($alldata['usrid']) && array_key_exists('bdid',$alldata) && isset($alldata['bdid']))
        {
            $usrp = User::find($alldata['usrid']);
            $bdp = BasedatosApp::find($alldata['bdid']);
            $exist = False;
            /*echo "<pre>";
            print_r();die();
            echo "</pre>";*/
            $bdsrelated = $usrp->basedatosapps()->get();

            foreach ($bdsrelated as $bd) {
                if ($bd->id == $alldata['bdid']){
                    $exist = True;
                }
            }

            if ($exist == True)
            {
                $response = array ('status' => 'Failure', 'result' => "<label  style=' color:#790D4E' class='control-label col-md-12 col-sm-12 col-xs-12'>Ya existe la relación con aplicación ".$bdp->aplicacion->app_nom." de ".$bdp->empresa->empr_nom."</label>");
            }
            else
            {
                 $usrp->basedatosapps()->attach($alldata['bdid']);
                 $btn = '<div 
                class="btn-group'.$bdp->id.'">
                    <button id="desvusrbtn'.$bdp->id.'" onclick="unrelatedb('.$bdp->id.', '.$usrp->id.');" class="btn btn-xs" data-placement="left" title="Desasociar usuario" style=" color:#053666; background-color:#FFFFFF;"><i class="fa fa-close fa-3x"></i> </button></div>';
                 $response = array ('status' => 'Success', 'result' => '<tr id="row'.$bdp->id.'">'.
                    
                                '<td>' . $bdp->aplicacion->app_nom . '</td>' .
                                '<td>' . $bdp->empresa->empr_nom . '</td>' .
                                '<td>' . $bdp->empresa->empr_rfc . '</td>' .
                                '<td>' . $btn . '</td>' .
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

        $file = false;
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
        /*if(array_key_exists('users_nick',$alldata) && isset($alldata['users_nick'])){
            $user->users_nick = $alldata['users_nick'];
        }*/

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

        $usr = $user = \Auth::user();
        if ($usr->can('editar.usuario'))
        {
            $user = User::findOrFail($id);
            $roles = Role::all();
            $permissions = Permission::all();
            return view('usuarioedit',['roles'=>$roles,'permissions'=>$permissions,'user'=>$user]); 
        }
        \Session::flash('failmessage','No tiene acceso a editar usuarios');
        return redirect()->back();
    }



    public function update(Request $request, $id)
    {
        $alldata = $request->all();
        $user = User::findOrFail($id);
        $name = '';
        $email ='';
     

        /*echo "<pre>";
        print_r($alldata);die();
        echo "</pre>";*/

        $file = false;
        if(array_key_exists('users_pic',$alldata)){
            $file = request()->file('users_pic');
            $path = $request->file('users_pic')->storeAs(
            'public', $user->id.'.'.$file->getClientOriginalName()
            );
           
        }

        if($file!=false){
            
            $user->users_pic = $user->id.'.'.$file->getClientOriginalName();
        }
        else
        {
            if(array_key_exists('checkpic',$alldata)){
                if($alldata['checkpic']==0 || $alldata['checkpic']=='0'){
                    $user->users_pic = null;
                }
            }
        }

        if(array_key_exists('users_tel',$alldata) && isset($alldata['users_tel'])){
            $user->users_tel = $alldata['users_tel'];
        }

        if(array_key_exists('name',$alldata) && isset($alldata['name'])){
            $user->name = $alldata['name'];
            $name = $alldata['name'];

        }
        else
        {
            $name = $user->name;
        }

        if(array_key_exists('email',$alldata) && isset($alldata['email'])){
            $user->email = $alldata['email'];
            $email = $alldata['email'];
        }
        else
        {
            $email = $user->email;
        }

        /*if(array_key_exists('users_nick',$alldata) && isset($alldata['users_nick'])){
            $user->users_nick = $alldata['users_nick'];
        }*/


        $user->save();


        $user->detachAllRoles();
        if(array_key_exists('roles',$alldata)){
            foreach ($alldata['roles'] as $rol) {
                $rolobj = Role::find($rol);
                $user->attachRole($rolobj);
            }
        }

        $user->detachAllPermissions();
        if(array_key_exists('permisos',$alldata)){
            foreach ($alldata['permisos'] as $perm) {
                $permobj = Permission::find($perm);
                $user->attachPermission($permobj);

            }
        }

        //actualizando email y nombre de usuario en instancias
        $inst_bd = $user->basedatosapps()->get();
        $arrayparams['usr'] = array('users_cuentaid'=>$id, 'name'=>$name, 'email'=>$email);

        foreach ($inst_bd as $inst) {
            $arrayparams['dbname'] = $inst->bdapp_nombd;
            $acces_vars = $this->getAccessToken($inst->bdapp_app);
            $service_response = $this->getAppService($acces_vars['access_token'],'moduser',$arrayparams,$inst->bdapp_app);
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
        $messagetype = 'failmessage';

        if ($user->id == Auth::user()->id){
            $fmessage = 'No es posible eliminar al usuario: '.$user->name.'  autenticado';
        }
        else
        {
            $bds = $user->basedatosapps()->get();
            Log::info($bds);
            $count_dep = 0;
            foreach ($bds as $bd) 
            {
                $acces_vars = $this->getAccessToken($bd->bdapp_app);
                $arrayparams['id_cuenta'] = $user->id;
                $arrayparams['dbname'] = $bd->bdapp_nombd;

                $service_response = $this->getAppService($acces_vars['access_token'],'dropuser',$arrayparams,$bd->bdapp_app);

                if ($service_response['status'] == 0)
                {
                    $count_dep += 1;
                }
            }

            if ($count_dep == 0)
            {
                $user->detachAllPermissions();
                $user->detachAllRoles();
                $user->basedatosapps()->detach();
                $fmessage = 'Se ha eliminado el usuario: '.$user->name;
                $messagetype = 'message';
                $user->delete();
                $this->registroBitacora($request,'delete',$fmessage);
            }
            else
            {
                $fmessage = 'No es posible eliminar al usuario: '.$user->name.' pues tiene dependencias asociadas en '.$count_dep.' soluciones creadas';
            }

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
        elseif (array_key_exists('email',$alldata) && isset($alldata['email']))
        {            
            $usr = User::where('email','=',$alldata['email'])->get();
            if (count($usr) > 0){
                $usrobj = User::find($usr[0]->id);
                $return_array = $usrobj->userPermissions()->get()->pluck('id');
            }
        }

        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
            'permissions' => $return_array
        );
        return \Response::json($response);
    } 


    public function changepass(Request $request)
    {
        $alldata = $request->all();
        //$this->customvalidator($alldata)->validate();

        Log::info($alldata['password']);

        $rules = ['password' => 'min:8|passwordsat|confirmed'];
        //$messages = ['passwordsat' => 'Contraseña inválida'];

        $validator = Validator::make($alldata, $rules)->validate();

        $return_array = array();
        $user_id = false;
        $fmessage = '';

       if(array_key_exists('user',$alldata) && isset($alldata['user'])){
            $user = User::find($alldata['user']);
            $user_id = $alldata['user'];
        }

       if($user!=false){
            if(array_key_exists('password',$alldata) && isset($alldata['password'])){
                $user->password = bcrypt($alldata['password']);
                $fmessage = 'Se cambió la contraseña satisfactoriamente a usuario '.$user->name;
                $this->registroBitacora($request,'password change',$fmessage);
                //\Session::flash('message', $fmessage); 
            }
            $user->password_change = true;

            $user->save();

            //actualizando password de usuario en instancias
            $inst_bd = $user->basedatosapps()->get();
            $dbname = \Session::get('selected_database',false);
            if ($dbname != false)
            {
                $password = DB::connection($dbname)->select('select password from users where id = ?',[$user->id]);
                if (count($password) > 0)
                {
                    $password = $password[0]->password;
                }
                $arrayparams['usr'] = array('users_cuentaid'=>$user->id, 'password'=>$password);

                foreach ($inst_bd as $inst) {
                    $arrayparams['dbname'] = $inst->bdapp_nombd;
                    $acces_vars = $this->getAccessToken($inst->bdapp_app);
                    $service_response = $this->getAppService($acces_vars['access_token'],'moduser',$arrayparams,$inst->bdapp_app);
                }
            }

            
        }

       

       $response = array(
            'status' => 'success',
            'msg' => $fmessage,
            'user' => $user_id,
        );
        return \Response::json($response);
    }


    public function getrolepermissionbd($bdid){

        $bd = BasedatosApp::find($bdid);
        $app_cod = $bd->bdapp_app;
        $gener_inst = config('app.advans_apps_gener_inst.'.$app_cod);
        $status = 0;
        $msg = 'Sin roles';
        $roles = array();

        if ($app_cod != 'fact')
        {
            $arrayparams['dbname'] = $bd->bdapp_nombd;
            $acces_vars = $this->getAccessToken($app_cod);
            $service_response = $this->getAppService($acces_vars['access_token'],'getroles',$arrayparams,$app_cod);
            $status = $service_response['status'];
            $msg = $service_response['msg'];
             if ($service_response['status'] == 1){
                $roles = $service_response['roles'];
             }
        }

         $response = array(
            'status' => $status,
            'msg' => $msg,
            'roles' => $roles,
            );

         return \Response::json($response);

        
         
    }
}
