<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ClientResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\TechPlanner\Filament\Resources\DeviceResource;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class DevicesRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'devices';

    protected static ?string $recordTitleAttribute = 'name';

    public static string $resource = DeviceResource::class;

    /*
     * public function getFormSchema(): array
     * {
     * return [
     * Forms\Components\TextInput::make('name')
     * ->required()
     * ->maxLength(255),
     * Forms\Components\TextInput::make('model')
     * ->required()
     * ->maxLength(255),
     * Forms\Components\TextInput::make('serial_number')
     * ->required()
     * ->maxLength(255),
     * Forms\Components\TextInput::make('inventory_number')
     * ->required()
     * ->maxLength(255),
     * Forms\Components\TextInput::make('location')
     * ->required()
     * ->maxLength(255),
     * Forms\Components\DatePicker::make('purchase_date')
     * ->required(),
     * Forms\Components\DatePicker::make('installation_date')
     * ->required(),
     * Forms\Components\DatePicker::make('warranty_expiration_date')
     * ->required(),
     * Forms\Components\DatePicker::make('next_maintenance_date')
     * ->required(),
     * Forms\Components\DatePicker::make('next_verification_date')
     * ->required(),
     * Forms\Components\Toggle::make('is_active')
     * ->required(),
     * ];
     * }
     */
    /*
     * public function table(Table $table): Table
     * {
     * return $table
     * ->columns([
     * Tables\Columns\TextColumn::make('name'),
     * Tables\Columns\TextColumn::make('model'),
     * Tables\Columns\TextColumn::make('serial_number'),
     * Tables\Columns\TextColumn::make('inventory_number'),
     * Tables\Columns\TextColumn::make('location'),
     * Tables\Columns\TextColumn::make('purchase_date')
     * ->date(),
     * Tables\Columns\TextColumn::make('installation_date')
     * ->date(),
     * Tables\Columns\TextColumn::make('warranty_expiration_date')
     * ->date(),
     * Tables\Columns\TextColumn::make('next_maintenance_date')
     * ->date(),
     * Tables\Columns\TextColumn::make('next_verification_date')
     * ->date(),
     * Tables\Columns\IconColumn::make('is_active')
     * ->boolean(),
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
