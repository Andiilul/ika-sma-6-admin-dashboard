<?php

namespace App\Filament\Resources\FundTransactions\Widgets;

use App\Models\FundTransaction;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FundMonthlyReportStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $start = now()->startOfMonth()->toDateString();
        $end   = now()->endOfMonth()->toDateString();

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
            Stat::make('Pemasukan (Bulan Ini)', $this->rp($income)),
            Stat::make('Pengeluaran (Bulan Ini)', $this->rp($expense)),
            Stat::make('Net (Bulan Ini)', $this->rp($net)),
        ];
    }

    private function rp(float $n): string
    {
        return 'Rp ' . number_format($n, 2, ',', '.');
    }
}