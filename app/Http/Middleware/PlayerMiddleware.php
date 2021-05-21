<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\CtfConfig;

class PlayerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( Auth::check() && Auth::User()->ctf_player == 1) {

            //Config not made by admin
            if(CtfConfig::all()->count() == 0){
                $inform = "The CTF isn't configurated by the admin";
                return redirect('home')->with(compact('inform'));    
            }

            return $next($request);
        }
        return redirect('login')->withErrors(["You have to sign in before being here",'The Message']);
    }
}
