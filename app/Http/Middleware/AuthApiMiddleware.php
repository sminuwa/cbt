<?php

namespace App\Http\Middleware;

use App\Models\Centre;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('api_key');
        $secretKey = $request->header('secret_key');

        if (!$apiKey || !$secretKey) {
            return response()->json(['error' => 'API key and Secret key are required.'], 401);
        }

        $credential = Centre::where('api_key', $apiKey)
            ->where('secret_key', $secretKey)
            ->first();

        if (!$credential) {
            return response()->json(['error' => 'Invalid API key or Secret key.'], 401);
        }

        return $next($request);
    }
}
