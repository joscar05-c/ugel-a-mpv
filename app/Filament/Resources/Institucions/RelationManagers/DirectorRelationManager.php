<?php

namespace App\Filament\Resources\Institucions\RelationManagers;

use App\Filament\Resources\Institucions\InstitucionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class DirectorRelationManager extends RelationManager
{
    protected static string $relationship = 'director';

    protected static ?string $relatedResource = InstitucionResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
