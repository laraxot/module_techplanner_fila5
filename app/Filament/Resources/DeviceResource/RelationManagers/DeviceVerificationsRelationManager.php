<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\DeviceResource\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DeviceVerificationsRelationManager extends RelationManager
{
    protected static string $relationship = 'deviceVerifications';

    protected static ?string $recordTitleAttribute = 'verification_date';

    public function schema(Schema $schema): Schema
    {
        return $schema->components([
            DatePicker::make('verification_date')->required(),
            DatePicker::make('next_verification_date')->required(),
            TextInput::make('verification_type')->maxLength(100),
            TextInput::make('verification_result')->maxLength(100),
            TextInput::make('verifier_name')->maxLength(100),
            TextInput::make('verifier_company')->maxLength(100),
            Textarea::make('notes')->maxLength(65535),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('verification_date')->date()->sortable(),
                TextColumn::make('next_verification_date')->date()->sortable(),
                TextColumn::make('verification_type')->searchable(),
                TextColumn::make('verification_result')->searchable(),
                TextColumn::make('verifier_name')->searchable(),
            ])
            ->filters([

            ])
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
