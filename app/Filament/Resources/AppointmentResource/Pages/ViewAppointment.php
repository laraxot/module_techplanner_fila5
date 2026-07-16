<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\AppointmentResource\Pages;

use Modules\TechPlanner\Filament\Resources\AppointmentResource;
use Modules\TechPlanner\Filament\Resources\AppointmentResource\Schemas\AppointmentInfolist;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Override;

class ViewAppointment extends XotBaseViewRecord
{
    protected static string $resource = AppointmentResource::class;

    #[Override]
    protected function getInfolistSchema(): array
    {
        return AppointmentInfolist::getInfolistSchema();
    }
}
