<?php

namespace App\Http\Middleware;

use App\Models\Perfil;
use Closure;

class RoleAdmin
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
            return redirect()->route('login');
        }

        if ($user->perfil == Perfil::ADMIN) {
            return $next($request);
        }

        \Auth::logout();
        return redirect()->route('login');
    }
}
