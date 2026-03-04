<?php

namespace App\Filament\Resources\FundTransactions\Widgets;

use App\Models\FundTransaction;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FundYearlyReportStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $start = now()->startOfYear()->toDateString();
        $end   = now()->endOfYear()->toDateString();

        $income = (float) FundTransaction::query()
            ->whereBetween('transaction_date', [$start, $end])
            ->where('type', 'income')
            ->sum('amount');

        $expense = (float) FundTransaction::query()
            ->whereBetween('transaction_date', [$start, $end])
            ->where('type', 'expense')
            ->sum('amount');

        $net = $income - $expense;

        return [
            Stat::make('Pemasukan (Tahun Ini)', $this->rp($income)),
            Stat::make('Pengeluaran (Tahun Ini)', $this->rp($expense)),
            Stat::make('Net (Tahun Ini)', $this->rp($net)),
        ];
    }

    private function rp(float $n): string
    {
        return 'Rp ' . number_format($n, 2, ',', '.');
    }
}