<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $tipo  // Tipo de usuário permitido
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $tipo)
    {
        // Verifica se o usuário está logado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Verifica se o tipo do usuário é o permitido
        if (Auth::user()->tipo_usuario !== $tipo) {
            // Redireciona com mensagem de erro
            return redirect('/dashboard')->with('error', 'Você não tem permissão para acessar esta página.');
        }

        return $next($request);
    }
}
