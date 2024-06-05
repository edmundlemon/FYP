<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('sanctum')->user();
        // Log::channel('api_post_log')->error('User', ['user' => $user]);
        if (Auth::guard('sanctum')->check() && $user->hasRole('student')) {
            return $next($request);
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
