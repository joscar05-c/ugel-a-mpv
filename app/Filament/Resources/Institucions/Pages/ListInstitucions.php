<?php

namespace App\Filament\Resources\Institucions\Pages;

use App\Filament\Imports\InstitucionImporter;
use App\Filament\Resources\Institucions\InstitucionResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListInstitucions extends ListRecords
{
    protected static string $resource = InstitucionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            ImportAction::make()
                ->importer(InstitucionImporter::class)
                ->label('Importar desde Excel/ CSV')
                ->color('succes')
                ->icon('heroicon-o-arrow-up-tray')
        ];
    }
}
