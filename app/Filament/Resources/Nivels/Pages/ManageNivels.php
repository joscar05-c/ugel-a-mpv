<?php

namespace App\Filament\Resources\Nivels\Pages;

use App\Filament\Resources\Nivels\NivelResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageNivels extends ManageRecords
{
    protected static string $resource = NivelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
