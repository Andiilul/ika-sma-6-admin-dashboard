<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\FundTransaction;
use Illuminate\Http\Request;

class FundTransactionController extends Controller
{
    /**
     * GET /api/v1/funds/summary
     * Response: total pemasukan, total pengeluaran, total keseluruhan (net) dalam range tanggal.
     */
    public function summary(Request $request)
    {
        $validated = $request->validate([
            'from'  => ['nullable', 'date'], // YYYY-MM-DD
            'until' => ['nullable', 'date'], // YYYY-MM-DD
        ]);

        $base = FundTransaction::query()
            ->when($validated['from'] ?? null, fn ($q, $from) =>
                $q->whereDate('transaction_date', '>=', $from)
            )
            ->when($validated['until'] ?? null, fn ($q, $until) =>
                $q->whereDate('transaction_date', '<=', $until)
            );

        $totalPemasukan  = (float) (clone $base)->where('type', 'income')->sum('amount');
        $totalPengeluaran = (float) (clone $base)->where('type', 'expense')->sum('amount');
        $totalKeseluruhan = $totalPemasukan - $totalPengeluaran;

        return response()->json([
            'status' => 'success',
            'data' => [
                'from' => $validated['from'] ?? null,
                'until' => $validated['until'] ?? null,
                'total_pemasukan' => $totalPemasukan,
                'total_pengeluaran' => $totalPengeluaran,
                'total_keseluruhan' => $totalKeseluruhan,
            ],
        ]);
    }
}