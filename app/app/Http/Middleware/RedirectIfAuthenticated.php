<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Staff; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\StaffController;

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
        //$pas=DB::table('staffs')->where('email','=','moezbeauty.ts@gmail.com')->first();
        //print 'RedirectIfAuthenticated<br>';
        //print "pas=".$pas['password']."<br>";

        //print "Auth::check0=".Auth::guard('staff')->check()."<br>";
        /*
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
        }
        */
        //print_r($guards);
        //print "Auth::check100=".Auth::guard('staff')->check()."<br>";
        foreach ($guards as $guard) {
            //print "guard=".$guard."<br>";
           
            if($guard == "admin" && Auth::guard($guard)->check()) {   //追記
                print "admin<br>";
                return redirect('admin/home');                        //追記
            }
            //if($guard == "staff" && Auth::guard($guard)->check()) {   //追記
            if($guard == "staff" && Auth::guard('staff')->check()) {   //追記
                print "staff true<br>";
                //return redirect('/MenuStaff');
                return redirect('staff.menu');                        //追記
            } 
            if (Auth::guard($guard)->check()) {
                print "guard100<br>";
                //return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
