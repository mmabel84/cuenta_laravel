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

            $usr = User::find($idusr);
            $usr->basedatosapps()->attach($idapp);
        }
        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
        );
        return \Response::json($response);
        

        //return 'Usuario agregado exitosamente';


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

        $this->relateUsrApp($usr->id,$request->bdapp_id);
        
        \Session::flash('message','Se ha creado el usuario: '.$request->name);
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
        \Session::flash('message','Se ha actualizado el usuario: '.$usru->name);
        return Redirect::to('usuarios');

    }

    public function destroy($id)
    {
        
        $usrd = User::find($id);
        \Session::flash('message','Se ha eliminado el usuario: '.$usrd->name);
        $usrd->delete();

        return Redirect::to('usuarios');


    }

}
