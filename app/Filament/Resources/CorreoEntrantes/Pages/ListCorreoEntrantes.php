<?php

namespace App\Filament\Resources\CorreoEntrantes\Pages;

use App\Filament\Resources\CorreoEntrantes\CorreoEntranteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCorreoEntrantes extends ListRecords
{
    protected static string $resource = CorreoEntranteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //CreateAction::make(),
        ];
    }
}
