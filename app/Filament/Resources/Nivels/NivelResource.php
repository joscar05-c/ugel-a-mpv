<?php

namespace App\Filament\Resources\Nivels;

use App\Filament\Resources\Nivels\Pages\CreateNivel;
use App\Filament\Resources\Nivels\Pages\EditNivel;
use App\Filament\Resources\Nivels\Pages\ListNivels;
use App\Filament\Resources\Nivels\Pages\ViewNivel;
use App\Filament\Resources\Nivels\RelationManagers\CursosRelationManager;
use App\Filament\Resources\Nivels\RelationManagers\GradosRelationManager;
use App\Filament\Resources\Nivels\Schemas\NivelForm;
use App\Filament\Resources\Nivels\Schemas\NivelInfolist;
use App\Filament\Resources\Nivels\Tables\NivelsTable;
use App\Models\Nivel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class NivelResource extends Resource
{
    protected static ?string $model = Nivel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return NivelForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return NivelInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NivelsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            CursosRelationManager::class,
            GradosRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNivels::route('/'),
            'create' => CreateNivel::route('/create'),
            'view' => ViewNivel::route('/{record}'),
            'edit' => EditNivel::route('/{record}/edit'),
        ];
    }
}
