<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class LegalOfficesTable extends XotBaseResourceTable
{
    /**
     * @return array<int|string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            // Telefono: card con una riga per colonna; id e date di sistema nascosti di default, provincia/paese da `md`.
            'id' => IDColumn::make('id')->toggleable(isToggledHiddenByDefault: true),
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'city' => TextColumn::make('city')->searchable()->sortable(),
            'province' => TextColumn::make('province')->searchable()->visibleFrom('md'),
            'country' => TextColumn::make('country')->searchable()->visibleFrom('md'),
            'phone' => TextColumn::make('phone')->searchable(),
            'email' => TextColumn::make('email')->searchable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
