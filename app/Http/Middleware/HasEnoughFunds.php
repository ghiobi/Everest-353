<?php

namespace App\Http\Middleware;

use Closure;

class HasEnoughFunds
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
        //TODO: logic

        return $next($request);
    }
}
