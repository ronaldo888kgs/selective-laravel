<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CheckAdminUser
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

        if(!Auth::check() || Auth::user()->is_admin != 1)
        {
            return redirect('login')->withErrors([
                'login_fail' => 'login failed'
            ]);
        }
        return $next($request);
    }
}
