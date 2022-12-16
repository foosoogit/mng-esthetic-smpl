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

        foreach ($guards as $guard) {
            //print "guard=".$guard."<br>";
           
            if($guard == "admin" && Auth::guard($guard)->check()) {   //追記
                //print "admin<br>";
                return redirect('admin/home');                        //追記
            }

            if($guard == "staff" && Auth::guard($guard)->check()) {   //追記
                //print "ログイン成功10<br>";
                $request->session()->regenerate();
                //return redirect()->intended('dashboard');
                //return redirect('staff.menu');
                //return redirect('staff.menu');
                return redirect('/menuStaff');
                //return redirect('/menu');                        //追記
            } 
            if (Auth::guard($guard)->check()) {
                //print "guard100<br>";
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
