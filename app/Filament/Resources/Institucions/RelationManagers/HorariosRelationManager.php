<?php

namespace App\Filament\Resources\Institucions\RelationManagers;

use App\Filament\Resources\Institucions\InstitucionResource;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HorariosRelationManager extends RelationManager
{
    protected static string $relationship = 'horarios';
    protected static ?string $title = 'Horarios';
    protected static ?string $relatedResource = InstitucionResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('dia_semana')
                    ->label('Día de la Semana')
                    ->options([
                        'Lunes' => 'Lunes',
                        'Martes' => 'Martes',
                        'Miércoles' => 'Miércoles',
                        'Jueves' => 'Jueves',
                        'Viernes' => 'Viernes',
                    ])
                    ->required(),
                TimePicker::make('hora_inicio')
                    ->label('Hora de Inicio')
                    ->required(),
                TimePicker::make('hora_fin')
                    ->label('Hora de Fin')
                    ->required(),
                TextInput::make('curso')
                    ->label('Curso')
                    ->required()
                    ->maxLength(255),
                TextInput::make('docente')
                    ->label('Docente')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('curso')
            ->columns([
                TextColumn::make('dia_semana')
                    ->label('Día de la Semana')
                    ->searchable(),
                TextColumn::make('hora_inicio')
                    ->label('Hora de Inicio')
                    ->time(),
                TextColumn::make('hora_fin')
                    ->label('Hora de Fin')
                    ->time(),
                TextColumn::make('curso')
                    ->label('Curso')
                    ->searchable(),
                TextColumn::make('docente')
                    ->label('Docente')
                    ->searchable(),
            ])
            ->filters([])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(), // Permite asociar horarios existentes
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(), // Permite desasociar (no elimina el registro)
                DeleteAction::make(),     // Elimina definitivamente
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
