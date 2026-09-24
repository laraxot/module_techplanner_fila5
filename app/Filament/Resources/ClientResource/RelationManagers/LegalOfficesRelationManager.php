<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ClientResource\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\TechPlanner\Filament\Resources\LegalOfficeResource;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;
use Override;

class LegalOfficesRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'legalOffices';

    protected static ?string $recordTitleAttribute = 'name';

    protected static string $resource = LegalOfficeResource::class;

    #[Override]
    public function getFormSchema(): array
    {
        return [
            TextInput::make('name')->required()->maxLength(100),
            TextInput::make('street_address')->maxLength(100),
            TextInput::make('street_number')->maxLength(10),
            TextInput::make('city')->maxLength(100),
            TextInput::make('province')->maxLength(2),
            TextInput::make('postal_code')->maxLength(5),
            TextInput::make('phone')->tel()->maxLength(20),
            TextInput::make('fax')->maxLength(20),
            TextInput::make('email')->email()->maxLength(255),
            Textarea::make('notes')->maxLength(65535),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('city')->searchable(),
                TextColumn::make('province')->searchable(),
                TextColumn::make('phone')->searchable(),
                TextColumn::make('email')->searchable(),
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
