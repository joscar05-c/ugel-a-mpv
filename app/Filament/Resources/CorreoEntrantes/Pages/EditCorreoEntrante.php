<?php

namespace App\Filament\Resources\CorreoEntrantes\Pages;

use App\Filament\Resources\CorreoEntrantes\CorreoEntranteResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCorreoEntrante extends EditRecord
{
    protected static string $resource = CorreoEntranteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
