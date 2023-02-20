<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthenticateStaff extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    
    protected function redirectTo($request)
    {
        //print "Auth::check=".Auth::guard('staff')->check()."<br>";
        //print "request->expectsJson=".$request->expectsJson()."<br>";
        //print "Auth::check=".Auth::check()."<br>";
        //print "attempt Authenticate=".Auth::guard('staff')->attempt($credentials)."<br>";
        if (! $request->expectsJson()) {
           //print "no<br>";
            //return route('login');
            return route('staff.menu');
            
            //return route('/staff/login');
            //return route('menuStaff');
            //return route('/home');
        }
    }
}