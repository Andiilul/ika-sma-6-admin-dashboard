<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\SessionWidget;
use Filament\Pages\Dashboard as BaseDashboard;

use App\Filament\Resources\Alumnis\Widgets\AlumniStats;
use App\Filament\Resources\Alumnis\Widgets\AlumniCharts;
use App\Filament\Resources\Alumnis\Widgets\RecentUpdateAlumni;

class AdminDashboard extends BaseDashboard
{
    // v5: NON-static
    protected string $view = 'filament.pages.admin-dashboard';

    // v5: method ini harus public (sesuai error kamu sebelumnya)
    public function getWidgets(): array
    {
        // kosongin supaya kita render widget MANUAL via blade per-section
        return [];
    }

    public function sessionWidgets(): array
    {
        return [
            SessionWidget::class,
        ];
    }

    public function alumniWidgets(): array
    {
        return [
            AlumniStats::class,
            AlumniCharts::class,
            RecentUpdateAlumni::class,
        ];
    }

    public function activityWidgets(): array
    {
        return [
            // ActivityStats::class,
            // RecentUpdateActivity::class,
        ];
    }
}
