<?php

namespace App\Filament\Resources\Cursos\RelationManagers;

use App\Filament\Resources\Cursos\CursoResource;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CompetenciasRelationManager extends RelationManager
{
    protected static string $relationship = 'competencias';
    protected static ?string $title = 'Competencias';

    protected static ?string $relatedResource = CursoResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('grado_id')
                    ->label('Grado')
                    ->options(function (RelationManager $livewire) {
                        // Filtramos los grados por el nivel_id del Curso actual
                        return \App\Models\Grado::where('nivel_id', $livewire->getOwnerRecord()->nivel_id)
                            ->pluck('nombre', 'id');
                    })
                    ->required(),
                Textarea::make('descripcion')
                    ->label('Descripción de la Competencia')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('descripcion')
            ->columns([
                TextColumn::make('grado.nombre')
                    ->label('Grado')
                    ->sortable(),
                TextColumn::make('descripcion')
                    ->wrap()
                    ->searchable(),
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
