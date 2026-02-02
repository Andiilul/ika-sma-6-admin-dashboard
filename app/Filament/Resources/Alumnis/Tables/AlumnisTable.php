<?php

namespace App\Filament\Resources\Alumnis\Tables;

use App\Models\Alumni;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Table;

class AlumnisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),


                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('graduation_year')
                    ->label('Graduation Year')
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Location')
                    ->sortable()
                    ->formatStateUsing(fn(?string $state) => match ($state) {
                        'makassar' => 'Makassar',
                        'non-makassar' => 'Outside Makassar',
                        default => '-',
                    }),


                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('phone')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('graduation_year')
                    ->label('Grad Year')
                    ->options(fn() => self::gradYearOptions()),
                Tables\Filters\SelectFilter::make('location')
                    ->label('Location')
                    ->options(self::locationOption()),
            ])
            ->defaultSort('graduation_year', 'desc')
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

    protected static function gradYearOptions(): array
    {
        return Alumni::query()
            ->select('graduation_year')
            ->whereNotNull('graduation_year')
            ->distinct()
            ->orderBy('graduation_year', 'desc')
            ->pluck('graduation_year', 'graduation_year')
            ->toArray();
    }
    protected static function locationOption(): array
    {
        return [
            'makassar' => 'Makassar',
            'non-makassar' => 'Outside Makassar',
        ];
    }
}
