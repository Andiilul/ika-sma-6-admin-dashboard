<?php

namespace App\Filament\Resources\UsersResources\Pages;

use App\Filament\Resources\UsersResources\UsersResourcesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUsers extends EditRecord
{
    protected static string $resource = UsersResourcesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
