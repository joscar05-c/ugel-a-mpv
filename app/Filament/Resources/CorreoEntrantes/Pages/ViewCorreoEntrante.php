<?php

namespace App\Filament\Resources\CorreoEntrantes\Pages;

use App\Filament\Resources\CorreoEntrantes\CorreoEntranteResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCorreoEntrante extends ViewRecord
{
    protected static string $resource = CorreoEntranteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //EditAction::make(),
        ];
    }
}
