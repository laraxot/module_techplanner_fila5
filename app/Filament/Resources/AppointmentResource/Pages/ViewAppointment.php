<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\AppointmentResource\Pages;

use Filament\Schemas\Components\Component;
use Modules\TechPlanner\Filament\Resources\AppointmentResource;
use Modules\TechPlanner\Filament\Resources\AppointmentResource\Schemas\AppointmentInfolist;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewAppointment extends XotBaseViewRecord
{
    protected static string $resource = AppointmentResource::class;

    /**
     * @return array<string, Component>
     */
    protected function getInfolistSchema(): array
    {
        return app(AppointmentInfolist::class)->getInfolistSchema();
    }
}
