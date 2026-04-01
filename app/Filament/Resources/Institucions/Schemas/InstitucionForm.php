<?php

namespace App\Filament\Resources\Institucions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class InstitucionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('cod_modular'),
                TextInput::make('nombre')
                    ->required(),
                Select::make('nivel')
                    ->options(['Inicial' => 'Inicial', 'Primaria' => 'Primaria', 'Secundaria' => 'Secundaria'])
                    ->required(),
                TextInput::make('lugar')
                    ->required(),
                TextInput::make('distrito')
                    ->required(),
                Select::make('caracteristica')
                    ->options([
                        'Unidocente' => 'Unidocente',
                        'Polidocente' => 'Polidocente',
                        'Multigrado' => 'Multigrado',
                        'Privada' => 'Privada',
                    ])
                    ->required(),
                TextInput::make('direccion'),
                TextInput::make('telefono_ie')
                    ->tel(),
                Textarea::make('link_drive')
                    ->columnSpanFull(),
            ]);
    }
}
