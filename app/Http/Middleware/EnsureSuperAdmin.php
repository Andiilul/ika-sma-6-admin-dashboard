<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureSuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            abort(401);
        }

        if (auth()->user()->role !== 'super-admin') {
            abort(403);
        }

        return $next($request);
    }
}
