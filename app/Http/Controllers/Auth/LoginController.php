<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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
    // protected $redirectTo = RouteServiceProvider::HOME;



    protected function redirectTo()
    {
        if (Auth::check()) {
            $role = Auth::user()->role;
            $user_id = Auth::user()->id;
    
            if ($role === 'admin') {
                return RouteServiceProvider::ADMIN;
            } elseif ($role === 'driver') {
                return RouteServiceProvider::DRIVER;
            } elseif ($role === 'owner') {
                return RouteServiceProvider::OWNER;
            } 
        }
        return RouteServiceProvider::HOME;
    }
    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
