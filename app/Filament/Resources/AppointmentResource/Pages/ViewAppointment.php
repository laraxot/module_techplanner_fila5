<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\AppointmentResource\Pages;

use Modules\TechPlanner\Filament\Resources\AppointmentResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Modules\TechPlanner\Filament\Resources\AppointmentResource\Schemas\AppointmentInfolist;

class ViewAppointment extends XotBaseViewRecord
{
    protected static string $resource = AppointmentResource::class;

    /**
     * @return array<string, \Filament\Schemas\Components\Component>
     */
    #[\Override]
    protected function getInfolistSchema(): array
    {
        return app(AppointmentInfolist::class)->getInfolistSchema();
    }
}
