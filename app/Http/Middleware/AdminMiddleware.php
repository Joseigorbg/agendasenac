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
        // Verifica se o usuário está autenticado e possui o papel 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Redireciona para a página inicial com uma mensagem de erro
        return redirect('/')->with('error', 'Você não tem permissão para acessar esta página.');
    }
}
