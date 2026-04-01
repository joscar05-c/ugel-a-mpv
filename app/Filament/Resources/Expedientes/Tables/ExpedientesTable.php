<?php

namespace App\Filament\Resources\Expedientes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ExpedientesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('numero_registro')
                    ->searchable(),
                TextColumn::make('tipo_documento_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('usuario_origen_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('email_remitente_temporal')
                    ->searchable(),
                TextColumn::make('prioridad')
                    ->badge(),
                TextColumn::make('folios')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('estado_actual_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('area_actual_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('usuario_actual_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
