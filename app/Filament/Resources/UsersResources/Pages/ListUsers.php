<?php

namespace App\Filament\Resources\UsersResources\Pages;

use App\Filament\Resources\UsersResources\UsersResourcesResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ListUsers extends ViewRecord
{
    protected static string $resource = UsersResourcesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
