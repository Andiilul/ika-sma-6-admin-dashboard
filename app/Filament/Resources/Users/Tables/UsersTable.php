<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            // Superadmin tidak bisa dipilih untuk bulk delete
            ->checkIfRecordIsSelectableUsing(fn(User $record): bool => !$record->isSuperAdmin())

            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state?->label() ?? (string) $state)
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                // Edit tetap boleh untuk superadmin
                EditAction::make(),

                // Delete tidak boleh untuk superadmin
                DeleteAction::make()
                    ->authorize(fn(User $record) => !$record->isSuperAdmin()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->before(function (DeleteBulkAction $action, Collection $selectedRecords): void {
                            if ($selectedRecords->contains(fn(User $record) => $record->isSuperAdmin())) {
                                Notification::make()
                                    ->danger()
                                    ->title('Superadmin tidak boleh dihapus')
                                    ->body('Lepas Super Admin dari selection dulu, lalu ulangi bulk delete.')
                                    ->persistent()
                                    ->send();

                                $action->halt();
                            }
                        }),
                ]),
            ]);
    }
}
