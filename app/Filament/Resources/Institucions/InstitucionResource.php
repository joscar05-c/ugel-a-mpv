<?php

namespace App\Filament\Resources\Institucions;

use App\Filament\Resources\Cursos\RelationManagers\CompetenciasRelationManager;
use App\Filament\Resources\Institucions\Pages\CreateInstitucion;
use App\Filament\Resources\Institucions\Pages\EditInstitucion;
use App\Filament\Resources\Institucions\Pages\ListInstitucions;
use App\Filament\Resources\Institucions\Pages\ViewInstitucion;
use App\Filament\Resources\Institucions\RelationManagers\DirectorRelationManager;
use App\Filament\Resources\Institucions\RelationManagers\MatriculasRelationManager;
use App\Filament\Resources\Institucions\Schemas\InstitucionForm;
use App\Filament\Resources\Institucions\Schemas\InstitucionInfolist;
use App\Filament\Resources\Institucions\Tables\InstitucionsTable;
use App\Models\Institucion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InstitucionResource extends Resource
{
    protected static ?string $model = Institucion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return InstitucionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InstitucionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InstitucionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            DirectorRelationManager::class,
            MatriculasRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInstitucions::route('/'),
            'create' => CreateInstitucion::route('/create'),
            'view' => ViewInstitucion::route('/{record}'),
            'edit' => EditInstitucion::route('/{record}/edit'),
        ];
    }
}
