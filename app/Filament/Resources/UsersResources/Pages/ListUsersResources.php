<?php

namespace App\Filament\Resources\UsersResources\Pages;

use App\Filament\Resources\UsersResources\UsersResourcesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUsersResources extends ListRecords
{
    protected static string $resource = UsersResourcesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
