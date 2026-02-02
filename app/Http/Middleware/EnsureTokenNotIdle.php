<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenNotIdle
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $token = $user?->currentAccessToken();

        // Kalau tidak ada token (harusnya sudah ditangani auth:sanctum), biarkan lewat.
        if (!$user || !$token) {
            return $next($request);
        }

        $idleMinutes = 30;

        $lastActivity = $token->last_used_at ?? $token->created_at;

        if ($lastActivity && now()->diffInMinutes($lastActivity) > $idleMinutes) {
            // Revoke token yang idle
            $token->delete();

            return response()->json([
                'message' => 'Token expired due to inactivity (idle 30 minutes).',
            ], 401);
        }

        // Optional: update last_used_at (Sanctum biasanya sudah update sendiri, tapi ini aman)
        $token->forceFill(['last_used_at' => now()])->save();

        return $next($request);
    }
}
