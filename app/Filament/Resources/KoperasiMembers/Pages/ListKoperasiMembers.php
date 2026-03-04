<?php

namespace App\Filament\Resources\KoperasiMembers\Pages;

use App\Filament\Resources\KoperasiMembers\KoperasiMemberResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKoperasiMembers extends ListRecords
{
    protected static string $resource = KoperasiMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
