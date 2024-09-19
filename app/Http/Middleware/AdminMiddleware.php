<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->cargo === 'Administrador') {
            return $next($request);
        }

        return redirect('/'); // Redireciona se o usuário não for administrador
    }
}
