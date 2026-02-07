<?php

namespace App\Filament\Widgets;

use Filament\Facades\Filament;
use Filament\Widgets\Widget;
use Illuminate\Support\Carbon;

class SessionWidget extends Widget
{
    // Filament v5: NON-static
    protected string $view = 'filament.widgets.session-widget';

    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        $user = Filament::auth()->user();

        $loginAt = session('filament_login_at')
            ? Carbon::parse(session('filament_login_at'))->timezone(config('app.timezone'))
            : null;

        return [
            'now' => now()->timezone(config('app.timezone')),
            'userEmail' => $user?->email ?? '-',
            'loginAt' => $loginAt,
        ];
    }
}
