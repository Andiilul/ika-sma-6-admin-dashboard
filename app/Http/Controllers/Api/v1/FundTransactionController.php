<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\FundTransaction;
use Illuminate\Http\Request;

class FundTransactionController extends Controller
{
    /**
     * GET /api/v1/funds/summary
     *
     * Query params:
     * - from   (nullable, YYYY-MM-DD)
     * - until  (nullable, YYYY-MM-DD)
     * - year   (nullable, integer)
     *
     * Response:
     * - summary_periode  => sesuai range from/until
     * - summary_tahunan  => sesuai year
     */
    public function summary(Request $request)
    {
        $validated = $request->validate([
            'from'  => ['nullable', 'date'],
            'until' => ['nullable', 'date'],
            'year'  => ['nullable', 'integer', 'min:2000', 'max:2100'],
        ]);

        // Tentukan tahun untuk summary tahunan
        $year = $validated['year']
            ?? (($validated['from'] ?? null) ? date('Y', strtotime($validated['from'])) : null)
            ?? (($validated['until'] ?? null) ? date('Y', strtotime($validated['until'])) : null)
            ?? now()->year;

        // =========================================
        // 1) SUMMARY PERIODE (mis. bulanan / range)
        // =========================================
        $periodQuery = FundTransaction::query()
            ->when($validated['from'] ?? null, fn ($q, $from) =>
                $q->whereDate('transaction_date', '>=', $from)
            )
            ->when($validated['until'] ?? null, fn ($q, $until) =>
                $q->whereDate('transaction_date', '<=', $until)
            );

        $periodSummary = $periodQuery
            ->selectRaw("
                COALESCE(SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END), 0) as total_pemasukan,
                COALESCE(SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END), 0) as total_pengeluaran
            ")
            ->first();

        $periodIncome = (float) $periodSummary->total_pemasukan;
        $periodExpense = (float) $periodSummary->total_pengeluaran;

        // =========================================
        // 2) SUMMARY TAHUNAN
        // =========================================
        $yearlyQuery = FundTransaction::query()
            ->whereYear('transaction_date', $year);

        $yearlySummary = $yearlyQuery
            ->selectRaw("
                COALESCE(SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END), 0) as total_pemasukan,
                COALESCE(SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END), 0) as total_pengeluaran
            ")
            ->first();

        $yearIncome = (float) $yearlySummary->total_pemasukan;
        $yearExpense = (float) $yearlySummary->total_pengeluaran;

        return response()->json([
            'status' => 'success',
            'data' => [
                'summary_periode' => [
                    'from' => $validated['from'] ?? null,
                    'until' => $validated['until'] ?? null,
                    'total_pemasukan' => $periodIncome,
                    'total_pengeluaran' => $periodExpense,
                    'total_keseluruhan' => $periodIncome - $periodExpense,
                ],
                'summary_tahunan' => [
                    'year' => (int) $year,
                    'total_pemasukan' => $yearIncome,
                    'total_pengeluaran' => $yearExpense,
                    'total_keseluruhan' => $yearIncome - $yearExpense,
                ],
            ],
        ]);
    }
}