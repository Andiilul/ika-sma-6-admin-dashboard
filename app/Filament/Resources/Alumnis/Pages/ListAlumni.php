<?php

namespace App\Filament\Resources\Alumnis\Pages;

use App\Filament\Resources\Alumnis\AlumniResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ListAlumni extends ViewRecord
{
    protected static string $resource = AlumniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
