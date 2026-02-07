<?php

namespace App\Filament\Resources\Alumnis\Widgets;

use App\Models\Alumni;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AlumniStats extends StatsOverviewWidget
{
    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        // One query for all location counts (more efficient than 3 separate counts)
        $byLocation = Alumni::query()
            ->selectRaw("COALESCE(NULLIF(location, ''), 'unknown') as loc, COUNT(*) as total")
            ->groupBy('loc')
            ->pluck('total', 'loc');

        $makassar = (int) ($byLocation['makassar'] ?? 0);
        $nonMakassar = (int) ($byLocation['non-makassar'] ?? 0);

        $startOfMonth = now()->startOfMonth();
        $startOfNextMonth = now()->startOfMonth()->addMonth();

        $addedThisMonth = Alumni::query()
            ->where('created_at', '>=', $startOfMonth)
            ->where('created_at', '<', $startOfNextMonth)
            ->count();


        $total = $makassar + $nonMakassar;

        return [
            Stat::make('Total Alumni', number_format($total))
                ->description(
                    'Added This Month: ' . number_format(
                        $addedThisMonth
                    )
                )

                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color($addedThisMonth > 0 ? 'success' : 'secondary'),

            Stat::make('Makassar Alumni', number_format($makassar))
                ->description(
                    'Non-Makassar: ' . number_format($nonMakassar)
                )
                ->descriptionIcon('heroicon-m-globe-asia-australia')
                ->color($makassar > 0 ? 'success' : 'secondary'),
        ];
    }
}
