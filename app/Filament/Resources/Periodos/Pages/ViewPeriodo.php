<?php

namespace App\Filament\Resources\Periodos\Pages;

use App\Filament\Resources\Periodos\PeriodoResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPeriodo extends ViewRecord
{
    protected static string $resource = PeriodoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
