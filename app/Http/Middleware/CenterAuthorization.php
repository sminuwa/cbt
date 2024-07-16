<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CenterAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        // Add your logic to check if the user belongs to an authorized center
        // For example:
        if (!$user || !$user->center_id || $user->center_id !== $request->center_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
