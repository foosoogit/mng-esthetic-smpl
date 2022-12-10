<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Staff; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;
        //$pas=Staff::where('email','=', 'oezbeauty.ts@gmail.com')->first('password');
        //$pas=DB::table('staffs')->where('email','=','moezbeauty.ts@gmail.com')->get();
        //$pas=DB::table('staffs')->get('email');
        //$pas=Staff::where('email','=', 'moezbeauty.ts@gmail.com')->first();
        $pas=DB::table('staffs')->where('email','=','moezbeauty.ts@gmail.com')->first();
        print 'RedirectIfAuthenticated<br>';
        //print "pas=".$pas['password']."<br>";
        /*
        print "pas=".$pas->password."<br>";
        if (Hash::check('00000101', $pas->password)) {
            print "パスワードが一致";
        }else{
            print "だめ";
        }
        */
        print "Auth::check0=".Auth::guard('staff')->check()."<br>";
        
        foreach ($guards as $guard) {
            print "guard=".$guard."<br>";
            print "Auth::check1=".Auth::guard($guard)->check()."<br>";
            if($guard == "admin" && Auth::guard($guard)->check()) {   //追記
                print "admin<br>";
                return redirect('admin/home');                        //追記
            }
            //if($guard == "staff" && Auth::guard($guard)->check()) {   //追記
            if($guard == "staff" && Auth::guard('staff')->check()) {   //追記
                print "staff true<br>";
                //return redirect('staff/home');                        //追記
            } 
            if (Auth::guard($guard)->check()) {
                print "guard100<br>";
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
