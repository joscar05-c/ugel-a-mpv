<?php

namespace App\Filament\Resources\Expedientes\Schemas;

use App\Models\Expediente;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ExpedienteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('numero_registro'),
                TextEntry::make('asunto')
                    ->columnSpanFull(),
                TextEntry::make('tipo_documento_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('usuario_origen_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('email_remitente_temporal')
                    ->placeholder('-'),
                TextEntry::make('prioridad')
                    ->badge(),
                TextEntry::make('folios')
                    ->numeric(),
                TextEntry::make('estado_actual_id')
                    ->numeric(),
                TextEntry::make('area_actual_id')
                    ->numeric(),
                TextEntry::make('usuario_actual_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Expediente $record): bool => $record->trashed()),
            ]);
    }
}
