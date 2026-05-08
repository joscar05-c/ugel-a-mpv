<?php

namespace App\Filament\Resources\Periodos\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PeriodoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre del Periodo')
                    ->placeholder('Ej: Primer Trimestre 2026')
                    ->required(),
                DatePicker::make('fecha_inicio')
                    ->label('Fecha de Inicio')
                    ->required(),
                DatePicker::make('fecha_fin')
                    ->label('Fecha de Ciere')
                    ->required(),
                Toggle::make('is_active')
                    ->label('¿Periodo Activo?')
                    ->default(false)
                    ->helperText('Solo un periodo debe estar activo a la vez.'),
            ]);
    }
}
