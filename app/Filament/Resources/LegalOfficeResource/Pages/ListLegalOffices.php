<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Modules\TechPlanner\Filament\Resources\LegalOfficeResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListLegalOffices extends XotBaseListRecords
{
    protected static string $resource = LegalOfficeResource::class;

    /**
     * Get table columns for LegalOffice list.
     *
     * @return array<string, TextColumn>
     */
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')
                ->sortable()
                ->searchable(),
            'city' => TextColumn::make('city')
                ->sortable()
                ->searchable(),
            'province' => TextColumn::make('province')
                ->sortable()
                ->searchable(),
            'phone' => TextColumn::make('phone')
                ->searchable(),
            'email' => TextColumn::make('email')
                ->searchable()
                ->sortable(),
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
