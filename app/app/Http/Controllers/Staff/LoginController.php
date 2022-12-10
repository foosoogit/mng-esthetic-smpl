<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Staff; 
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

    /*
    public function authenticate(Request $request)
    {
        $pas=Staff::where('email','=', 'oezbeauty.ts@gmail.com')->first('password');
        

        if (Hash::check('00000101', $pas)) {
            print "パスワードが一致";
        }else{
            print "だめ2";
        }

        $credentials = $request->only(['email', 'password']);

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        
        if (Auth::guard('staff')->attempt($credentials)) {
        //if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
        /*

        print "Auth::attempt=".Auth::attempt($credentials)."<br>";
        if (Auth::guard('staff')->attempt($credentials)){
        //if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }
        */
    //}

    public function login(Request $request) {
        print 'LoginController<br>';
        $credentials = $request->only(['email', 'password']);
        //$guard = $request->guard;
        $guard = 'staff';
        print "attempt=".Auth::guard($guard)->attempt($credentials)."<br>";
        //if(Auth::guard($guard)->attempt($credentials)) {
        if(Auth::guard('staff')->attempt($credentials)) {
            
            //print '認証に成功しました<br>';
            //return redirect($guard .'/home'); // ログインしたらリダイレクト
            //return redirect($redirectTo);
            return redirect('staff/home');
        }        
        return back()->withErrors([
            'auth' => ['認証に失敗しました']
        ]);
    }

    /*
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (Auth::guard('staff')->attempt($credentials)) {
            print "ログインしたら管理画面トップにリダイレクト";
            return redirect()->route('admin.index')->with([
                'login_msg' => 'ログインしました。',
            ]);
        }

        return back()->withErrors([
            'login' => ['ログインに失敗しました'],
        ]);
    }
    */
    public function logout(Request $request)                //追記
    {                                                       //追記
        $this->performLogout($request);                     //追記
        return redirect('staff/login');                     //追記
    }
    /*
    protected function create(array $data)
    {
        return Staff::create([                  //修正
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
    */
}
