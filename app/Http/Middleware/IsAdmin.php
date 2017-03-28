<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

///////////////// Esse Middleware foi criado para proteger certas URL's do acesso
///////////////// de pessoas que não sejam administradores.

class IsAdmin
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
        if(Auth::user()->is_admin)

            return $next($request);

        else

            return redirect('/');
    }
}
