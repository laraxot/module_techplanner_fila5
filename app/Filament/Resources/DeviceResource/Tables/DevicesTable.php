<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\DeviceResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class DevicesTable extends XotBaseResourceTable
{
    /**
     * @return array<int|string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable()->searchable(),
            'client_id' => TextColumn::make('client_id')->sortable()->searchable(),
            'type' => TextColumn::make('type')->sortable()->searchable(),
            'brand' => TextColumn::make('brand')->sortable()->searchable(),
            'model' => TextColumn::make('model')->sortable()->searchable(),
            'headset_serial' => TextColumn::make('headset_serial')->sortable()->searchable(),
            'tube_serial' => TextColumn::make('tube_serial')->sortable()->searchable(),
            'kv' => TextColumn::make('kv')->sortable()->searchable(),
            'ma' => TextColumn::make('ma')->sortable()->searchable(),
            'first_verification_date' => TextColumn::make('first_verification_date')->sortable()->searchable(),
            'notes' => TextColumn::make('notes')->sortable()->searchable()->wrap(),
        ];
    }
}
