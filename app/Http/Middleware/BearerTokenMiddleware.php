<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BearerTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     *
     * Check request on isset token
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $token = substr($authHeader, 7);

        if ($token !== config('app.api_bearer_token')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
