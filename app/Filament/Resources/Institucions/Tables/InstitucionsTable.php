<?php

namespace App\Filament\Resources\Institucions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class InstitucionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('cod_modular')
                    ->searchable(),
                TextColumn::make('nombre')
                    ->searchable(),
                TextColumn::make('nivel')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Inicial' => 'warning',
                        'Primaria' => 'info',
                        'Secundaria' => 'succes',
                        default => 'gray',
                    }),
                TextColumn::make('lugar')
                    ->searchable(),
                TextColumn::make('distrito')
                    ->searchable(),
                TextColumn::make('caracteristica')
                    ->badge(),
                TextColumn::make('link_drive')
                    ->label('Horarios')
                    ->formatStateUsing(fn() => 'Ver Drive')
                    ->url(fn($record) => $record->link_drive)
                    ->openUrlInNewTab()
                    ->icon('heroicon-m-arrow-top-right-on-square')
                    ->color('primary'),
                /* TextColumn::make('direccion')
                    ->searchable(),
                TextColumn::make('telefono_ie')
                    ->searchable(), */
                /* TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), */
            ])
            ->filters([
                SelectFilter::make('nivel')
                    ->options([
                        'Inicial' => 'Inicial',
                        'Primaria' => 'Primaria',
                        'Secundaria' => 'Secundaria',
                    ]),
                SelectFilter::make('caracteristica')
                    ->options([
                        'Unidocente' => 'Unidocente',
                        'Polidocente' => 'Polidocente',
                        'Multigrado' => 'Multigrado',
                        'Privada' => 'Privada',
                    ])
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
