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
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Modules\TechPlanner\Filament\Resources\LegalRepresentativeResource;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class LegalRepresentativesRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'legalRepresentatives';

    protected static ?string $recordTitleAttribute = 'full_name';

    protected static string $resource = LegalRepresentativeResource::class;

    /**
     * @return array<int|string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            TextInput::make('first_name')->required()->maxLength(100),
            TextInput::make('last_name')->required()->maxLength(100),
            TextInput::make('fiscal_code')->maxLength(16),
            TextInput::make('phone')->tel()->maxLength(20),
            TextInput::make('mobile')->tel()->maxLength(20),
            TextInput::make('email')->email()->maxLength(255),
            Toggle::make('is_inactive')->default(false),
            Textarea::make('notes')->maxLength(65535),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')->searchable(['first_name', 'last_name']),
                IconColumn::make('is_inactive')->boolean(),
                TextColumn::make('fiscal_code')->searchable(),
                TextColumn::make('phone')->searchable(),
                TextColumn::make('email')->searchable(),
            ])
            ->filters([
                TernaryFilter::make('is_inactive'),
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
