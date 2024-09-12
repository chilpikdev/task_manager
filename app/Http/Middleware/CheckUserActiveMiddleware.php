<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiErrorException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserActiveMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth('sanctum')->user()->isActive) {
            throw new ApiErrorException(403, "User is not active");
        }

        return $next($request);
    }
}
