<?php

namespace App\Http\Middleware;

use Closure;

class Administrator
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
        // если пользователь не админ -> 404
        if ( ! auth()->user()->admin) {
            abort(404);
        }
        return $next($request);
    }
}
