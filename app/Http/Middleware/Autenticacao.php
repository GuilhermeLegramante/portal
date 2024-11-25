<?php

namespace App\Http\Middleware;

use Closure;

class Autenticacao
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
        // Verifica se existe a Session de Login e redireciona
        session_start();
        if (isset($_SESSION['login'])) {
            if ($_SESSION['login'] == 'logado') {
                return $next($request);
            }
        } else {
            return redirect()->route('login');
        }
    }
}
