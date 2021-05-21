<?php

namespace App\Http\Middleware;

use Closure;
use App\CtfConfig;

class StartedMiddleware
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
        //Config not made by admin
        if(CtfConfig::all()->count() == 0){
            $inform = "The CTF isn't configurated by the admin";
            return redirect()->route('home')->with(compact('inform')); 
        }else {
            $conf = CtfConfig::first();
            if ( strtotime(now()) > strtotime($conf->date_start)) {
                if ( strtotime(now()) < strtotime($conf->date_end)) {
                    return $next($request);
                }else{
                    $inform = "The CTF is finished";
                    return redirect()->route('home')->with(compact('inform'));                    
                }
            }else{
                $inform = "The CTF has not started yet :(";
                return redirect()->route('home')->with(compact('inform'));             
            }
        }
    }
}
