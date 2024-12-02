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
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // Получаем токен из заголовка Authorization
        $authHeader = $request->header('Authorization');

        // Проверяем, что заголовок начинается с "Bearer "
        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Извлекаем токен
        $token = substr($authHeader, 7);

        // Сравниваем токен с тем, что указан в .env
        if ($token !== config('app.api_bearer_token')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
