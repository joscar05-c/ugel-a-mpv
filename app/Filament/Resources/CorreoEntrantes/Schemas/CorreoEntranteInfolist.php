<?php

namespace App\Filament\Resources\CorreoEntrantes\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CorreoEntranteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->schema([
                        //columna izquierda datos del correo
                        Section::make('Detalles del mensaje')
                            ->schema([
                                TextEntry::make('remitente_email')->label('De'),
                                TextEntry::make('fecha_recepcion_correo')->label('Fecha')->dateTime('d/m/Y H:i'),
                                TextEntry::make('asunto')->label('Asunto')->weight('bold'),
                                TextEntry::make('cuerpo_texto')
                                    ->label('Contenido')
                                    ->html()
                                    ->prose()
                            ])
                            ->columnSpan(1),
                        //columna derecha del visor del pdf
                        Section::make('Documentos Adjuntos')
                            ->schema([
                                ViewEntry::make('rutas_adjuntos')
                                    ->view('filament.infolists.components.visor-pdf')
                            ])
                            ->columnSpan(2)
                    ]),
            ]);
    }
}
