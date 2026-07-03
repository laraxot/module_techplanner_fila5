<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\Pages;

use Filament\Tables\Columns\TextColumn;
use Modules\TechPlanner\Filament\Resources\DeviceResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListDevices extends XotBaseListRecords
{
    protected static string $resource = DeviceResource::class;

    public function getTableColumns(): array
    {
        return [
            TextColumn::make('name')->searchable()->sortable(),
            TextColumn::make('serial_number')->searchable()->sortable(),
            TextColumn::make('model')->searchable()->sortable(),
            TextColumn::make('manufacturer')->searchable()->sortable(),
        ];
    }
}
