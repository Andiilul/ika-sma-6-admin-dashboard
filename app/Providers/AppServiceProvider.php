<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        RateLimiter::for('auth-login', function (Request $request) {
            $email = (string) $request->input('email', '');

            // 5 percobaan / menit per kombinasi email + IP
            return Limit::perMinute(5)->by(strtolower($email) . '|' . $request->ip());
        });
    }
}
