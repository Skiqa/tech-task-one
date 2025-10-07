<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $staticKey = config('services.api.static_key');
        $clientKey = $request->header('X-API-KEY');

        if (!$clientKey || $clientKey !== $staticKey) {
            return response()->json([
                'error' => 'Ошибка авторизации: вы не авторизованы.'
            ], 401);
        }

        return $next($request);
    }
}
