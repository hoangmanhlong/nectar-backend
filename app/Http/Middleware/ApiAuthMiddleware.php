<?php

namespace App\Http\Middleware;

use App\Models\AppResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken(); // Automatically get token from Authorization header
        if (!$token || !auth()->setToken($token)->check()) {
            return AppResponse::unauthorized();
        }

        return $next($request);
    }
}
