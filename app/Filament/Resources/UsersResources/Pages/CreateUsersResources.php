<?php

namespace App\Filament\Resources\UsersResources\Pages;

use App\Filament\Resources\UsersResources\UsersResourcesResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUsersResources extends CreateRecord
{
    protected static string $resource = UsersResourcesResource::class;

    protected function afterCreate(): void
    {
        // otomatis role admin
        $this->record->assignRole('admin');
    }
}
