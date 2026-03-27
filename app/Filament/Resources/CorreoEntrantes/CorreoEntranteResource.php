<?php

namespace App\Filament\Resources\CorreoEntrantes;

use App\Filament\Resources\CorreoEntrantes\Pages\CreateCorreoEntrante;
use App\Filament\Resources\CorreoEntrantes\Pages\EditCorreoEntrante;
use App\Filament\Resources\CorreoEntrantes\Pages\ListCorreoEntrantes;
use App\Filament\Resources\CorreoEntrantes\Pages\ViewCorreoEntrante;
use App\Filament\Resources\CorreoEntrantes\Schemas\CorreoEntranteForm;
use App\Filament\Resources\CorreoEntrantes\Schemas\CorreoEntranteInfolist;
use App\Filament\Resources\CorreoEntrantes\Tables\CorreoEntrantesTable;
use App\Models\CorreoEntrante;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CorreoEntranteResource extends Resource
{
    protected static ?string $model = CorreoEntrante::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'asunto';

    public static function form(Schema $schema): Schema
    {
        return CorreoEntranteForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CorreoEntranteInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CorreoEntrantesTable::configure($table);
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
            'index' => ListCorreoEntrantes::route('/'),
            // 'create' => CreateCorreoEntrante::route('/create'),
            'view' => ViewCorreoEntrante::route('/{record}'),
            // 'edit' => EditCorreoEntrante::route('/{record}/edit'),
        ];
    }
}
