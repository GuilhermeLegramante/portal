<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Redirect;

class Auth
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
        if (Session::get('login_contracheque') == true) {
            return $next($request);
        } else {
            return Redirect::to(env('URL_LOGIN'));
        }
    }
}
