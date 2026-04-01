<?php

namespace App\Filament\Resources\Institucions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InstitucionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informacion de la Institucion')
                    ->schema(
                        [
                            TextEntry::make('nombre'),
                            TextEntry::make('nivel'),
                            TextEntry::make('distrito'),
                            TextEntry::make('lugar'),
                            TextEntry::make('caracteristica'),
                            TextEntry::make('link_drive')
                                ->label('Enlace de Horarios')
                                ->url(fn($record) => $record->link_drive)
                                ->color('primary')
                                ->openUrlInNewTab(),
                        ]
                    )->columns(2),
            ]);
    }
}
