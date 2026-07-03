<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ClientResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\TechPlanner\Filament\Resources\PhoneCallResource;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class PhoneCallsRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'phoneCalls';

    protected static string $resource = PhoneCallResource::class;

    /*
     * public function form(Form $form): Form
     * {
     * return $form
     * ->schema([
     * Forms\Components\TextInput::make('name')
     * ->required()
     * ->maxLength(255),
     * ]);
     * }
     *
     * public function table(Table $table): Table
     * {
     * return $table
     * ->recordTitleAttribute('name')
     * ->columns([
     * Tables\Columns\TextColumn::make('name'),
     * ])
     * ->filters([
     * ])
     * ->headerActions([
     * Tables\Actions\CreateAction::make(),
     * ])
     * ->actions([
     * Tables\Actions\EditAction::make(),
     * Tables\Actions\DeleteAction::make(),
     * ])
     * ->bulkActions([
     * Tables\Actions\BulkActionGroup::make([
     * Tables\Actions\DeleteBulkAction::make(),
     * ]),
     * ]);
     * }
     */
}
