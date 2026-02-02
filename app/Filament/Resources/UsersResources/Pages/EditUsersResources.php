<?php

namespace App\Filament\Resources\UsersResources\Pages;

use App\Filament\Resources\UsersResources\UsersResourcesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUsersResources extends EditRecord
{
    protected static string $resource = UsersResourcesResource::class;

    protected function authorizeAccess(): void
    {
        parent::authorizeAccess();

        abort_if($this->record->hasRole('super-admin'), 403);
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
