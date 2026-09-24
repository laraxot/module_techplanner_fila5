<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class VerificheRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'verifiche';

    protected static ?string $recordTitleAttribute = 'data_verifica';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('data_verifica')->dateTime(),
                TextColumn::make('esito'),
                TextColumn::make('note'),
            ])
            ->filters([])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
