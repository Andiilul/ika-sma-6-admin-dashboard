<?php

namespace App\Filament\Resources\FundTransactions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;

class FundTransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('proof_image_path')
                    ->label('Bukti')
                    ->disk('public')
                    ->square()
                    ->toggleable(),

                TextColumn::make('transaction_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => $state === 'income' ? 'Income' : 'Expense')
                    ->sortable(),

                TextColumn::make('amount')
                    ->label('Jumlah')
                    ->alignEnd()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format((float) $state, 2, ',', '.')),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('source')
                    ->label('Sumber')
                    ->toggleable(),

                TextColumn::make('payment_method')
                    ->label('Metode')
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Tipe')
                    ->options([
                        'income' => 'Income',
                        'expense' => 'Expense',
                    ]),

                SelectFilter::make('source')
                    ->label('Sumber')
                    ->options([
                        'koperasi_business' => 'Hasil Usaha Koperasi',
                        'member_dues'       => 'Iuran Anggota',
                        'donation'          => 'Donasi',
                        'external_support'  => 'Bantuan Eksternal',
                        'other'             => 'Lainnya',
                    ]),

                SelectFilter::make('payment_method')
                    ->label('Metode')
                    ->options([
                        'cash'     => 'Cash',
                        'transfer' => 'Transfer Bank',
                        'qris'     => 'QRIS',
                        'ewallet'  => 'E-Wallet',
                        'other'    => 'Lainnya',
                    ]),

                Filter::make('transaction_date_range')
                    ->label('Rentang Tanggal')
                    ->form([
                        DatePicker::make('from')->label('Dari')->native(false),
                        DatePicker::make('until')->label('Sampai')->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'] ?? null, fn (Builder $q, $date) => $q->whereDate('transaction_date', '>=', $date))
                            ->when($data['until'] ?? null, fn (Builder $q, $date) => $q->whereDate('transaction_date', '<=', $date));
                    }),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('transaction_date', 'desc');
    }
}