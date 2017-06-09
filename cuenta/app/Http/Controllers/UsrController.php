<?php

namespace App\Http\Controllers;
use App\User;
use App\BasedatosApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use View;

class UsrController extends Controller
{
    use RegistersUsers;

    public function index()
    {       

        $usuario = User::all();
        $apps = BasedatosApp::all();

        return view('usuarios',['apps'=>$apps,'usuarios'=>$usuario]);

    }

    public function create()
    {       

    	$apps = BasedatosApp::all();
       return View::make('usuariocreate')->with('apps',$apps);

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

    public function store(Request $request)
    {
        
        $usr = new User;
        $usr->name = $request->name;
        $usr->email = $request->email;
        $usr->users_nick = $request->users_nick;
        $usr->users_tel = $request->users_tel;
        $usr->password = bcrypt($request['password']);
        $usr->save();
        $msg_bd = 'Se ha creado el usuario: '.$request->name.$msg_bd;


        if ($request->addinstcheck == True){
            $result = $this.verifyUserInBd($usr->id, $request->bdapp_id);
            
            if ($result['exist'] == False){
                $usr->basedatosapps()->attach($request->bdapp_id);
            }
            
            $msg_bd = $msg_bd.$result['msg'];

       }

        \Session::flash('message',$msg_bd);
        return Redirect::to('usuarios');


    }

    

    public function edit($id)
    {       

        $usre = User::find($id);
        $apps = BasedatosApp::all();
        return view('usuarioedit',['apps'=>$apps,'usr'=>$usre]);
    }



    public function update(Request $request, $id)
    {
        $usru = User::find($id);
        $usru->name = $request->name;
        $usru->users_tel = $request->users_tel;
        $usru->email = $request->email;
        $usru->users_nick = $request->users_nick;


        $usru->save();
        $msg_update = 'Se ha actualizado el usuario: '.$usru->name;
        
        if ($request->addinstcheck == True){
            $result = $this.verifyUserInBd($usru->id, $request->bdapp_id);
            
            if ($result['exist'] == False){
                $usru->basedatosapps()->attach($request->bdapp_id);
            }
            
            $msg_update = $msg_update.$result['msg'];
        }
        \Session::flash('message',$msg_update);
        return Redirect::to('usuarios');

    }

    

    public function destroy($id)
    {
        
        $usrd = User::find($id);
        \Session::flash('message','Se ha eliminado el usuario: '.$usrd->name);
        $usrd->delete();

        return Redirect::to('usuarios');


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

}
