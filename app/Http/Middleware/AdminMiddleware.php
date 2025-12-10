<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Se não estiver logado, envia para o login
        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with('error', 'Você precisa estar logado.');
        }

        // Verifica se o usuário é administrador
        if (Auth::user()->cargo !== 'Administrador') {
            return response()->view('painel.erro-acesso');
        }

        // Permite continuar
        return $next($request);
    }
}
