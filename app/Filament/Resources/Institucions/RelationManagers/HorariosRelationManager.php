<?php

namespace App\Filament\Resources\Institucions\RelationManagers;

use App\Filament\Resources\Horarios\HorarioResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class HorariosRelationManager extends RelationManager
{
    protected static string $relationship = 'horarios';

    protected static ?string $relatedResource = HorarioResource::class;

    public function table(Table $table): Table
    {
        return $table
        ->recordTitleAttribute('curso')
        ->columns([
            TextColumn::make('dia_semana')
                ->badge()
                ->color('info'),
            TextColumn::make('hora_inicio')
                ->time('h:i A')
                ->label('Desde'),
            TextColumn::make('hora_fin')
                ->time('h:i A')
                ->label('Hasta'),
            TextColumn::make('curso')
                ->searchable(),
        ])
        ->defaultSort('dia_semana', 'asc') // Podrías usar un "case when" para ordenar días lógicamente
        ->filters([
            SelectFilter::make('dia_semana')
                ->options([
                    'Lunes' => 'Lunes',
                    'Martes' => 'Martes',
                    'Miércoles' => 'Miércoles',
                    'Jueves' => 'Jueves',
                    'Viernes' => 'Viernes',
                ]),
        ]);
    }
}
