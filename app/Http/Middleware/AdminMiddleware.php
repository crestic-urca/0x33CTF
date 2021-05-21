<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\CtfConfig;

class AdminMiddleware
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
        if (Auth::check() && Auth::User()->admin == 1) {
            //Config not made by admin
            if(CtfConfig::all()->count() == 0){
                if($request->route()->getName() != 'admin.config' && $request->route()->getName() != 'admin.configuration'){
                    $inform = "Please configure the CTF before using it";
                    return redirect()->route('admin.config')->with(compact('inform')); 
                }
            }
            return $next($request);
        }
        return redirect('home');
    }
}
