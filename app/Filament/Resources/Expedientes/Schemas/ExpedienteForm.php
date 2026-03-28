<?php

namespace App\Filament\Resources\Expedientes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ExpedienteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('numero_registro')
                    ->required(),
                Textarea::make('asunto')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('tipo_documento_id')
                    ->numeric(),
                TextInput::make('usuario_origen_id')
                    ->numeric(),
                TextInput::make('email_remitente_temporal')
                    ->email(),
                Select::make('prioridad')
                    ->options(['Baja' => 'Baja', 'Normal' => 'Normal', 'Alta' => 'Alta', 'Urgente' => 'Urgente'])
                    ->default('Normal')
                    ->required(),
                TextInput::make('folios')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('estado_actual_id')
                    ->required()
                    ->numeric(),
                TextInput::make('area_actual_id')
                    ->required()
                    ->numeric(),
                TextInput::make('usuario_actual_id')
                    ->numeric(),
            ]);
    }
}
