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
use Filament\Schemas\Components\Component;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\TechPlanner\Filament\Resources\MedicalDirectorResource;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class MedicalDirectorsRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'medicalDirectors';

    protected static ?string $recordTitleAttribute = 'name';

    protected static string $resource = MedicalDirectorResource::class;

    /**
     * @return array<int|string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            TextInput::make('name')->required()->maxLength(255),
            TextInput::make('fiscal_code')->maxLength(16),
            TextInput::make('phone')->tel()->maxLength(255),
            TextInput::make('email')->email()->maxLength(255),
            Textarea::make('notes')->maxLength(65535),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('fiscal_code'),
                TextColumn::make('phone'),
                TextColumn::make('email'),
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
