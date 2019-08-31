<?php

namespace App\Http\Middleware;

use Closure;

class SlowDown
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
        usleep(rand(50000, 400000));

        return $next($request);
    }
}
