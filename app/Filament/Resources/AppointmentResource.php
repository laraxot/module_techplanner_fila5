<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources;

use Illuminate\Database\Eloquent\Model;
use Modules\TechPlanner\Filament\Resources\AppointmentResource\Pages\CreateAppointment;
use Modules\TechPlanner\Filament\Resources\AppointmentResource\Pages\EditAppointment;
use Modules\TechPlanner\Filament\Resources\AppointmentResource\Pages\ListAppointments;
use Modules\TechPlanner\Filament\Resources\AppointmentResource\Pages\ViewAppointment;
use Modules\TechPlanner\Filament\Resources\AppointmentResource\Schemas\AppointmentForm;
use Modules\TechPlanner\Filament\Resources\AppointmentResource\Schemas\AppointmentInfolist;
use Modules\TechPlanner\Models\Appointment;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class AppointmentResource extends XotBaseResource
{
    protected static ?string $model = Appointment::class;

   
}
