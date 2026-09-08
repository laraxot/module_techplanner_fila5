<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\AppointmentResource\Pages;

use Modules\TechPlanner\Filament\Resources\AppointmentResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewAppointment extends XotBaseViewRecord
{
    protected static string $resource = AppointmentResource::class;
}
