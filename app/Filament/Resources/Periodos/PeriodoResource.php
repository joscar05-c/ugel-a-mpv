<?php

namespace App\Filament\Resources\Periodos;

use App\Filament\Resources\Periodos\Pages\CreatePeriodo;
use App\Filament\Resources\Periodos\Pages\EditPeriodo;
use App\Filament\Resources\Periodos\Pages\ListPeriodos;
use App\Filament\Resources\Periodos\Pages\ViewPeriodo;
use App\Filament\Resources\Periodos\Schemas\PeriodoForm;
use App\Filament\Resources\Periodos\Schemas\PeriodoInfolist;
use App\Filament\Resources\Periodos\Tables\PeriodosTable;
use App\Models\Periodo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PeriodoResource extends Resource
{
    protected static ?string $model = Periodo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return PeriodoForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PeriodoInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PeriodosTable::configure($table);
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
            'index' => ListPeriodos::route('/'),
            'create' => CreatePeriodo::route('/create'),
            'view' => ViewPeriodo::route('/{record}'),
            'edit' => EditPeriodo::route('/{record}/edit'),
        ];
    }
}
