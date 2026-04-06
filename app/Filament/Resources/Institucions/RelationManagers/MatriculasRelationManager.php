<?php

namespace App\Filament\Resources\Institucions\RelationManagers;

use App\Filament\Resources\Institucions\InstitucionResource;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MatriculasRelationManager extends RelationManager
{
    protected static string $relationship = 'matriculas';
    protected static ?string $title = 'Matrículas';

    protected static ?string $relatedResource = InstitucionResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('grado_id')
                    ->relationship('grado', 'nombre')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('anio_academico')
                    ->label('Año Académico')
                    ->default(date('Y'))
                    ->numeric()
                    ->required(),
                TextInput::make('cant_hombres')
                    ->label('Cantidad de Hombres')
                    ->numeric()
                    ->default(0)
                    ->required(),
                TextInput::make('cant_mujeres')
                    ->label('Cantidad de Mujeres')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('anio_academico')
            ->columns([
                TextColumn::make('anio_academico')
                    ->label('Año')
                    ->sortable(),
                TextColumn::make('grado.nombre')
                    ->label('Grado'),
                TextColumn::make('cant_hombres')
                    ->label('Hombres'),
                TextColumn::make('cant_mujeres')
                    ->label('Mujeres'),
                // Columna calculada para el total (opcional pero útil)
                TextColumn::make('total')
                    ->label('Total Alumnos')
                    ->state(function ($record) {
                        return $record->cant_hombres + $record->cant_mujeres;
                    }),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
