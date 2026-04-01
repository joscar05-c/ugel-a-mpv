<?php

namespace App\Filament\Imports;

use App\Models\Institucion;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class InstitucionImporter extends Importer
{
    protected static ?string $model = Institucion::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('cod_modular')
                ->rules(['max:255']),
            ImportColumn::make('nombre')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('nivel')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('lugar')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('distrito')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('caracteristica')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('direccion')
                ->rules(['max:255']),
            ImportColumn::make('telefono_ie')
                ->rules(['max:255']),
            ImportColumn::make('link_drive')
                ->label('Enlace de Horario'),
        ];
    }

    public function resolveRecord(): Institucion
    {
        return Institucion::firstOrNew([
            'cod_modular' => $this->data['cod_modular'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'La importacion de instituciones a finalizado ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' importadas.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' filas fallaron al importar.';
        }

        return $body;
    }
}
