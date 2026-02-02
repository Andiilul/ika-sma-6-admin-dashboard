<?php

namespace App\Filament\Resources\UsersResources\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Support\Collection;

class UsersResourcesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('role')->label('Role')->badge(),
            ])
            ->recordActions([
                EditAction::make()
                    ->authorize(fn ($record) => ! $record->hasRole('super-admin')),
                DeleteAction::make()
                    ->authorize(fn ($record) => ! $record->hasRole('super-admin')),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        // HAPUS authorize() yang ngecek $records, karena itu bikin before() gak kepanggil.
                        ->before(function (DeleteBulkAction $action, Collection $selectedRecords): void {
                            if ($selectedRecords->contains(fn ($record) => $record->hasRole('super-admin'))) {
                                Notification::make()
                                    ->danger()
                                    ->title('Super-admin tidak boleh dihapus')
                                    ->body('Lepas user super-admin dari selection dulu, lalu ulangi bulk delete.')
                                    ->persistent()
                                    ->send(); // send() yang bikin toast muncul :contentReference[oaicite:1]{index=1}

                                $action->halt();   // stop proses, modal tetap terbuka :contentReference[oaicite:2]{index=2}
                                // $action->cancel(); // kalau mau modal auto nutup :contentReference[oaicite:3]{index=3}
                            }
                        }),
                ]),
            ]);
    }
}
