<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\LegalRepresentativeResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Modules\TechPlanner\Filament\Resources\LegalRepresentativeResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListLegalRepresentatives extends XotBaseListRecords
{
    protected static string $resource = LegalRepresentativeResource::class;

    /**
     * Get table columns for LegalRepresentative list.
     *
     * @return array<string, TextColumn>
     */
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')
                ->sortable()
                ->searchable(),
            'email' => TextColumn::make('email')
                ->searchable()
                ->sortable(),
            'phone' => TextColumn::make('phone')
                ->searchable(),
            'fiscal_code' => TextColumn::make('fiscal_code')
                ->searchable(),
            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
        ];
    }

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            'create' => CreateAction::make(),
        ];
    }
}
