<?php

namespace App\Filament\Resources\Nivels\Pages;

use App\Filament\Resources\Nivels\NivelResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewNivel extends ViewRecord
{
    protected static string $resource = NivelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
