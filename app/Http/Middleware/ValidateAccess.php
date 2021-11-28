<?php

namespace App\Http\Middleware;

use App\Models\Perfil;
use Closure;

class ValidateAccess
{

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $rolEme
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        date_default_timezone_set("America/Bahia");
        $user = auth()->user();

        if ($user == null) {
            \Auth::logout();
            return redirect()->route('home');
        }

        if ($user->perfil == Perfil::ADMIN) {
            return $next($request);
        }

        /*$rotaPerfil = $request->session()->get('rotas', []);
        $rotaPerfil = array_merge($rotaPerfil, ['admin.sair', 'admin.home']);
        $nameRoute = \Route::current()->action["as"];

        if ($nameRoute == "admin.naoautorizado") {
            return $next($request);
        }

        if (!in_array($nameRoute, $rotaPerfil)) {
            return redirect()->route('admin.naoautorizado');
        }*/

        return $next($request);

    }
}
