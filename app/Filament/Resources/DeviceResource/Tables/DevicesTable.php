<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\DeviceResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class DevicesTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            // Telefono: la card ha una riga per colonna. Il tecnico cerca "di chi e' e che apparecchio e'":
            // il cliente va per nome (prima era il numero grezzo del client_id), id/kv/mA/note da `md`.
            'id' => IDColumn::make('id')->toggleable(isToggledHiddenByDefault: true),
            'client.company_name' => TextColumn::make('client.company_name')
                ->label(__('techplanner::device.fields.client_id.label'))
                ->sortable()
                ->searchable(),
            'type' => TextColumn::make('type')->sortable()->searchable(),
            'brand' => TextColumn::make('brand')->sortable()->searchable(),
            'model' => TextColumn::make('model')->sortable()->searchable(),
            'headset_serial' => TextColumn::make('headset_serial')->sortable()->searchable(),
            'tube_serial' => TextColumn::make('tube_serial')->sortable()->searchable(),
            'kv' => TextColumn::make('kv')->sortable()->searchable()->visibleFrom('md'),
            'ma' => TextColumn::make('ma')->sortable()->searchable()->visibleFrom('md'),
            'first_verification_date' => TextColumn::make('first_verification_date')->sortable()->searchable(),
            'notes' => TextColumn::make('notes')->sortable()->searchable()->wrap()->visibleFrom('md'),
        ];
    }
}
