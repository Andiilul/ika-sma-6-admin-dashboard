<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #111; }
        .header { margin-bottom: 14px; }
        .header h2 { margin: 0 0 6px 0; font-size: 16px; }
        .meta { font-size: 11px; color: #444; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px 8px; vertical-align: top; }
        th { background: #f5f5f5; text-align: left; }
        .num { text-align: right; white-space: nowrap; }
        .muted { color: #777; }
        .summary { margin-top: 12px; width: 100%; }
        .summary td { border: none; padding: 4px 0; }
        .summary .label { width: 70%; }
        .summary .val { width: 30%; text-align: right; white-space: nowrap; }
        .footer { margin-top: 10px; font-size: 10px; color: #666; }
    </style>
</head>
<body>
@php
    $fmt = function ($n) {
        return 'Rp ' . number_format((float) $n, 2, ',', '.');
    };

    $sourceLabel = function (?string $v) {
        return match ($v) {
            'koperasi_business' => 'Hasil Usaha Koperasi',
            'member_dues'       => 'Iuran Anggota',
            'donation'          => 'Donasi',
            'external_support'  => 'Bantuan Eksternal',
            'other', null       => 'Lainnya',
            default             => $v,
        };
    };

    $methodLabel = function (?string $v) {
        return match ($v) {
            'cash'     => 'Cash',
            'transfer' => 'Transfer',
            'qris'     => 'QRIS',
            'ewallet'  => 'E-Wallet',
            'other', null => 'Lainnya',
            default    => $v,
        };
    };
@endphp

<div class="header">
    <h1>IKA SMAN 6 Makassar</h1>
    <h2>{{ $title }}</h2>
    <div class="meta">
        Periode: <strong>{{ $periodLabel }}</strong>
        <span class="muted">({{ $dateFrom }} s/d {{ $dateTo }})</span><br>
        Scope: <strong>{{ $scopeLabel }}</strong><br>
        Generated: {{ $generatedAt }}
    </div>
</div>

<table>
    <thead>
    <tr>
        <th style="width: 12%;">Date</th>
        <th style="width: 28%;">Name</th>
        <th style="width: 18%;">Source</th>
        <th style="width: 14%;">Method</th>
        <th style="width: 14%;" class="num">Pemasukan</th>
        <th style="width: 14%;" class="num">Pengeluaran</th>
    </tr>
    </thead>
    <tbody>
    @forelse($transactions as $tx)
        @php
            $isIncome = $tx->type === 'income';
            $incomeVal = $isIncome ? $fmt($tx->amount) : '-';
            $expenseVal = !$isIncome ? $fmt($tx->amount) : '-';
        @endphp
        <tr>
            <td>{{ \Illuminate\Support\Carbon::parse($tx->transaction_date)->format('Y-m-d') }}</td>
            <td>{{ $tx->name }}</td>
            <td>{{ $sourceLabel($tx->source) }}</td>
            <td>{{ $methodLabel($tx->payment_method) }}</td>
            <td class="num">{{ $incomeVal }}</td>
            <td class="num">{{ $expenseVal }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="muted">Tidak ada data pada periode ini.</td>
        </tr>
    @endforelse
    </tbody>
</table>

<table class="summary">
    <tr>
        <td class="label"><strong>Total Pemasukan</strong></td>
        <td class="val"><strong>{{ $fmt($totalIncome) }}</strong></td>
    </tr>
    <tr>
        <td class="label"><strong>Total Pengeluaran</strong></td>
        <td class="val"><strong>{{ $fmt($totalExpense) }}</strong></td>
    </tr>
    <tr>
        <td class="label"><strong>Total Keseluruhan (Pemasukan - Pengeluaran)</strong></td>
        <td class="val"><strong>{{ $fmt($netTotal) }}</strong></td>
    </tr>
</table>

<div class="footer">
    Catatan: kolom “Pemasukan” hanya terisi bila tipe <strong>income</strong>, dan “Pengeluaran” hanya terisi bila tipe <strong>expense</strong>.
</div>
</body>
</html>