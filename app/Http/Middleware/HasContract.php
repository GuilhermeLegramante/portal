<?php

namespace App\Http\Middleware;

use Closure;

class HasContract
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
        if (session('tem_contrato_ativo')) {
            return $next($request);
        } else {
            return redirect()->route('dashboard')->with('error', 'Munícipe sem contratos ativos.');
        }
    }
}
