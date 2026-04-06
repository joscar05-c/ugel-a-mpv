<?php

namespace App\Filament\Resources\Institucions\RelationManagers;

use App\Filament\Resources\Institucions\InstitucionResource;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;

class DirectorRelationManager extends RelationManager
{
    protected static string $relationship = 'director';
    protected static ?string $title = 'Directores';

    protected static ?string $relatedResource = InstitucionResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('dni')
                    ->label('DNI')
                    ->required()
                    ->numeric()
                    ->maxLength(8),
                TextInput::make('nombres')
                    ->label('Nombres')
                    ->required()
                    ->maxLength(255),
                TextInput::make('apellido_paterno')
                    ->label('Apellido Paterno')
                    ->required()
                    ->maxLength(255),
                TextInput::make('apellido_materno')
                    ->label('Apellido Materno')
                    ->required()
                    ->maxLength(255),
                TextInput::make('celular')
                    ->label('Celular')
                    ->tel() // Añade validación básica de teléfono
                    ->maxLength(20),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('dni')
                    ->label('DNI')
                    ->searchable(),
                TextColumn::make('nombres')
                    ->label('Nombres')
                    ->searchable(),
                TextColumn::make('apellido_paterno')
                    ->label('Ap. Paterno')
                    ->searchable(),
                TextColumn::make('apellido_materno')
                    ->label('Ap. Materno')
                    ->searchable(),
                TextColumn::make('celular')
                    ->label('Celular'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }
}
