<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Staff;  
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

    //use AuthenticatesUsers;
    use AuthenticatesUsers {                                //追記
        logout as performLogout;                            //追記
    }    

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/staff/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
        $this->middleware('guest:staff')->except('logout');
    }

    protected function guard()                  //追記
    {                                           //追記
        return Auth::guard('staff');            //追記
    }

    public function logout(Request $request)                //追記
    {                                                       //追記
        $this->performLogout($request);                     //追記
        return redirect('staff/login');                     //追記
    }

    protected function create(array $data)
    {
        return Staff::create([                  //修正
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
