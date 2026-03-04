<?php

namespace App\Filament\Resources\FundTransactions\Pages;

use App\Filament\Resources\FundTransactions\FundTransactionResource;
use App\Models\FundTransaction;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Carbon;

// NOTE: Ini butuh package PDF (dompdf / dll). Kalau belum ter-install, bagian Pdf ini akan error.
use Barryvdh\DomPDF\Facade\Pdf;

class ListFundTransactions extends ListRecords
{
    protected static string $resource = FundTransactionResource::class;

    protected function getHeaderActions(): array
    {
        $yearNow = now()->year;

        $yearOptions = [];
        for ($y = $yearNow; $y >= $yearNow - 10; $y--) {
            $yearOptions[(string) $y] = (string) $y;
        }

        $monthOptions = [
            '1'  => 'Januari',
            '2'  => 'Februari',
            '3'  => 'Maret',
            '4'  => 'April',
            '5'  => 'Mei',
            '6'  => 'Juni',
            '7'  => 'Juli',
            '8'  => 'Agustus',
            '9'  => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        return [
            CreateAction::make(),

            Action::make('createReport')
                ->label('Buat Laporan')
                ->icon('heroicon-o-document-arrow-down')
                ->modalHeading('Create Report / Buat Laporan')
                ->modalSubmitActionLabel('Generate PDF')
                ->form([
                    Select::make('period')
                        ->label('Jenis Laporan')
                        ->options([
                            'monthly' => 'Bulanan',
                            'yearly'  => 'Tahunan',
                        ])
                        ->default('monthly')
                        ->required()
                        // Pilih salah satu sesuai versi Filament kamu:
                        ->reactive(),
                        // ->live(),

                    Select::make('month')
                        ->label('Bulan')
                        ->options($monthOptions)
                        ->default((string) now()->month)
                        ->required()
                        ->visible(fn (callable $get) => $get('period') === 'monthly'),

                    Select::make('year')
                        ->label('Tahun')
                        ->options($yearOptions)
                        ->default((string) now()->year)
                        ->required(),

                    Select::make('scope')
                        ->label('Generate Laporan Untuk')
                        ->options([
                            'all'     => 'Semua (Cashflow)',
                            'income'  => 'Pemasukan saja',
                            'expense' => 'Pengeluaran saja',
                        ])
                        ->default('all')
                        ->required(),
                ])
                ->action(function (array $data) {
                    $period = $data['period'];
                    $year   = (int) $data['year'];
                    $month  = isset($data['month']) ? (int) $data['month'] : null;
                    $scope  = $data['scope'];

                    if ($period === 'monthly') {
                        $start = Carbon::create($year, $month, 1)->startOfMonth();
                        $end   = Carbon::create($year, $month, 1)->endOfMonth();
                        $periodLabel = Carbon::create($year, $month, 1)->format('F Y');
                    } else {
                        $start = Carbon::create($year, 1, 1)->startOfYear();
                        $end   = Carbon::create($year, 12, 31)->endOfYear();
                        $periodLabel = (string) $year;
                    }

                    $scopeLabel = match ($scope) {
                        'income'  => 'Pemasukan saja',
                        'expense' => 'Pengeluaran saja',
                        default   => 'Semua (Cashflow)',
                    };

                    $transactions = FundTransaction::query()
                        ->whereDate('transaction_date', '>=', $start->toDateString())
                        ->whereDate('transaction_date', '<=', $end->toDateString())
                        ->when($scope !== 'all', fn ($q) => $q->where('type', $scope))
                        ->orderBy('transaction_date')
                        ->orderBy('created_at')
                        ->get();

                    $totalIncome  = (float) $transactions->where('type', 'income')->sum('amount');
                    $totalExpense = (float) $transactions->where('type', 'expense')->sum('amount');
                    $netTotal     = $totalIncome - $totalExpense;

                    $title = 'Laporan Keuangan Koperasi';

                    $pdf = Pdf::loadView('reports.fund_transactions', [
                        'title'        => $title,
                        'periodLabel'  => $periodLabel,
                        'dateFrom'     => $start->toDateString(),
                        'dateTo'       => $end->toDateString(),
                        'scopeLabel'   => $scopeLabel,
                        'generatedAt'  => now()->format('Y-m-d H:i:s'),
                        'transactions' => $transactions,
                        'totalIncome'  => $totalIncome,
                        'totalExpense' => $totalExpense,
                        'netTotal'     => $netTotal,
                    ])->setPaper('a4', 'portrait');

                    $suffix = $period === 'monthly'
                        ? sprintf('%04d-%02d', $year, $month)
                        : sprintf('%04d', $year);

                    $filename = "laporan-keuangan-{$suffix}-{$scope}.pdf";

                    return response()->streamDownload(
                        fn () => print($pdf->output()),
                        $filename
                    );
                }),
        ];
    }
}