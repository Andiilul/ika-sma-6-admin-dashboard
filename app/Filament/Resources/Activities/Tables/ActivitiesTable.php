<?php

namespace App\Filament\Resources\Activities\Tables;

use App\Models\Activity;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Table;

class ActivitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // Cover image (disimpan seperti Alumni)
                // NOTE: kalau kolom kamu namanya `image`, ganti make('image_path') -> make('image')
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Cover')
                    ->disk('public')
                    ->height(44)
                    ->width(70)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('date')
                    ->label('Date')
                    ->date('Y-m-d')
                    ->sortable(),

                Tables\Columns\TextColumn::make('location')
                    ->label('Location')
                    ->sortable()
                    ->formatStateUsing(fn (?string $state) => $state ?: '-')
                    ->toggleable(),

                // Description (rich text HTML) - sanitized render
                Tables\Columns\TextColumn::make('short_description')
                    ->label('Short Description')
                    ->limit(80),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('date')
                    ->label('Date')
                    ->options(fn () => self::dateOptions()),

                Tables\Filters\SelectFilter::make('location')
                    ->label('Location')
                    ->options(fn () => self::locationOptions()),
            ])
            ->defaultSort('date', 'desc')
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Filter opsi tanggal berdasarkan data yang ada (distinct).
     * Format "YYYY-MM-DD".
     */
    protected static function dateOptions(): array
    {
        return Activity::query()
            ->select('date')
            ->whereNotNull('date')
            ->distinct()
            ->orderBy('date', 'desc')
            ->pluck('date', 'date')
            ->toArray();
    }

    /**
     * Location itu free text (nullable), jadi opsinya diambil dari data yang ada.
     */
    protected static function locationOptions(): array
    {
        return Activity::query()
            ->select('location')
            ->whereNotNull('location')
            ->where('location', '!=', '')
            ->distinct()
            ->orderBy('location')
            ->pluck('location', 'location')
            ->toArray();
    }
}

