<?php

namespace App\Filament\Resources\Expedientes;

use App\Filament\Resources\Expedientes\Pages\CreateExpediente;
use App\Filament\Resources\Expedientes\Pages\EditExpediente;
use App\Filament\Resources\Expedientes\Pages\ListExpedientes;
use App\Filament\Resources\Expedientes\Pages\ViewExpediente;
use App\Filament\Resources\Expedientes\Schemas\ExpedienteForm;
use App\Filament\Resources\Expedientes\Schemas\ExpedienteInfolist;
use App\Filament\Resources\Expedientes\Tables\ExpedientesTable;
use App\Models\Expediente;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExpedienteResource extends Resource
{
    protected static ?string $model = Expediente::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'numero_registro';

    public static function form(Schema $schema): Schema
    {
        return ExpedienteForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ExpedienteInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExpedientesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListExpedientes::route('/'),
            'create' => CreateExpediente::route('/create'),
            'view' => ViewExpediente::route('/{record}'),
            'edit' => EditExpediente::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
