<?php

namespace App\Filament\Resources\Alumnis\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Alumni;

class AlumniCharts extends ChartWidget
{
    protected ?string $heading = 'Alumni by Graduation Year';
    protected function getData(): array
    {
        $rows = Alumni::query()
            ->selectRaw('graduation_year, COUNT(*) as total')
            ->groupBy('graduation_year')
            ->orderBy('graduation_year')
            ->pluck('total', 'graduation_year');

        return [
            'datasets' => [
                [
                    'label' => 'Total alumni',
                    'data' => $rows->values(),
                ],
            ],
            'labels' => $rows->keys(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
