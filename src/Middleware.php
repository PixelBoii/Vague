<?php

namespace PixelBoii\Vague;

use Closure;
use Illuminate\Http\Request;

class Middleware
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
        if (!$this->userHasAccess($request)) {
            return response()->view('vague::errors.403');
        }

        return $next($request);
    }
}