<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources;

use Modules\TechPlanner\Models\Appointment;
use Modules\Xot\Filament\Resources\XotBaseResource;

class AppointmentResource extends XotBaseResource
{
    protected static ?string $model = Appointment::class;
}
