<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\AppointmentResource\Pages;

use Modules\TechPlanner\Filament\Resources\AppointmentResource;
use Modules\TechPlanner\Filament\Resources\AppointmentResource\Tables\AppointmentsTable;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

/**
 * @property AppointmentResource $resource
 */
class ListAppointments extends XotBaseListRecords
{
    protected static string $resource = AppointmentResource::class;

    public function getTableColumns(): array
    {
        return (new AppointmentsTable())->getTableColumns();
    }
}
