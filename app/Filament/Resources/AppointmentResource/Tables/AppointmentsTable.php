<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\AppointmentResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class AppointmentsTable extends XotBaseResourceTable
{
    /**
     * @return array<int|string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            // Telefono: la card ha una riga per colonna. Per aprire un appuntamento servono cliente e quando;
            // id e date di sistema sono nascosti di default (riattivabili dal selettore colonne), le note da `md`.
            'id' => IDColumn::make('id')->toggleable(isToggledHiddenByDefault: true),
            'client.name' => TextColumn::make('client.name')->searchable()->sortable(),
            'date' => TextColumn::make('date')->dateTime()->sortable(),
            'notes' => TextColumn::make('notes')->limit(50)->visibleFrom('md'),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
