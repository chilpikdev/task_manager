<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChangeLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = 'X-Language';

        if ($request->hasHeader($key) && $request->header($key)) {
            $locale = $request->header($key);
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
