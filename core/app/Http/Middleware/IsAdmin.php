<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verifica se o usuário está autenticado
        if (!Auth::check()) {
            return redirect()->route('admin.loginForm')->with('error', 'Por favor, faça login para continuar.');
        }

        // Verifica se o usuário é admin
        $user = Auth::user();

        // Verifica pela tabela admins ou pelo role
        if ($user->role === 'admin' || $user->is_admin || Auth::guard('admin')->check()) {
            return $next($request);
        }

        // Não é admin, redireciona
        abort(403, 'Acesso negado. Você não tem permissão para acessar esta área.');
    }
}
