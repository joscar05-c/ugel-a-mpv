<?php

namespace App\Filament\Resources\Cursos\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CursoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('nivel_id')
                    ->relationship('nivel', 'nombre')
                    ->required()
                    ->preload()
                    ->searchable(),
                TextInput::make('nombre')
                    ->required(),
            ]);
    }
}
