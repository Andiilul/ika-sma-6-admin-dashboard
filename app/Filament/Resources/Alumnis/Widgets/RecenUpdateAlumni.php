<?php

namespace App\Filament\Resources\Alumnis\Widgets;

use App\Models\Alumni;
use Filament\Actions\Action;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentUpdateAlumni extends TableWidget
{
    protected static ?string $heading = 'Recently Updated Alumni';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn(): Builder => Alumni::query()
                    ->latest('updated_at')
                    ->take(10)
            )
            ->paginated(false) // hides pagination UI + per-page selector

            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name'),
                Tables\Columns\TextColumn::make('graduation_year')
                    ->label('Year'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Update')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_by')
                    ->label('Updated By')
                    ->getStateUsing(fn(Alumni $record) => $record->updatedBy?->email ?? '-'),
            ])
            ->headerActions([
                Action::make('viewAll')
                    ->label('View all alumni')
                    ->icon('heroicon-m-arrow-top-right-on-square')
                    ->url('/admin/alumnis'),
            ]);
    }
}
