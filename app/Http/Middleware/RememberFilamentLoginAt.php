<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;



class RememberFilamentLoginAt
{
    public function handle($request, Closure $next)
    
    {
        if (Filament::auth()->check()) {
            if (! $request->session()->has('filament_login_at')) {
                $request->session()->put('filament_login_at', now()->toIso8601String());
            }
        } else {
            $request->session()->forget('filament_login_at');
        }

        return $next($request);
    }
    
}
