<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\MedicalDirectorResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class MedicalDirectorsTable extends XotBaseResourceTable
{
    /**
     * @return array<int|string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            // Telefono: card con una riga per colonna; id e date di sistema nascosti di default.
            'id' => IDColumn::make('id')->toggleable(isToggledHiddenByDefault: true),
            'name' => TextColumn::make('name')->sortable()->searchable(),
            'email' => TextColumn::make('email')->sortable()->searchable(),
            'phone' => TextColumn::make('phone')->sortable()->searchable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
