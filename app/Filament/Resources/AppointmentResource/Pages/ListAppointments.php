<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\AppointmentResource\Pages;

use Filament\Tables\Columns\TextColumn;
use Modules\TechPlanner\Filament\Resources\AppointmentResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

/**
 * @property AppointmentResource $resource
 */
class ListAppointments extends XotBaseListRecords
{
    protected static string $resource = AppointmentResource::class;

    public function getTableColumns(): array
    {
        return [
            'client.name' => TextColumn::make('client.name')->searchable()->sortable(),
            'date' => TextColumn::make('date')->date()->sortable(),
            'time' => TextColumn::make('time')->time()->sortable(),
            'status' => TextColumn::make('status')->searchable()->sortable(),
            'notes' => TextColumn::make('notes')->searchable()->wrap(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
        ];
    }
}
