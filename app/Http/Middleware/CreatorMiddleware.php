<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class CreatorMiddleware
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
        if (Auth::check() && Auth::User()->ctf_creator == 1) {
            return $next($request);
        }
        return redirect('login')->withErrors(["You have to sign in before being here",'The Message']);
    }
}
