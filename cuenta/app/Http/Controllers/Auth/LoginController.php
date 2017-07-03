<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $lockoutTime = 1;
    protected $maxLoginAttempts = 3;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function setLoginAttempts()
    {
        if (method_exists($this, 'maxLoginAttempts')) {
            
            return $this->maxLoginAttempts();
        }
 
        return property_exists($this, 'maxLoginAttempts') ? $this->maxLoginAttempts : 5;
    }

    protected function setLockoutTime()
    {
        if (method_exists($this, 'lockoutTime')) {
            
            return $this->lockoutTime();
        }
 
        return property_exists($this, 'lockoutTime') ? $this->lockoutTime : 1; 
    }
    



   


     protected function throttleKey(Request $request)
    {

        return Str::lower($request->input($this->username()));
    }




}
