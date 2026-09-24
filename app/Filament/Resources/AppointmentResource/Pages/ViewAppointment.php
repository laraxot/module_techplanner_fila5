<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\AppointmentResource\Pages;

use Modules\TechPlanner\Filament\Resources\AppointmentResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
<<<<<<< HEAD
use Modules\TechPlanner\Filament\Resources\AppointmentResource\Schemas\AppointmentInfolist;
=======
>>>>>>> laraxot/dev

class ViewAppointment extends XotBaseViewRecord
{
    protected static string $resource = AppointmentResource::class;
<<<<<<< HEAD

    /**
     * @return array<string, \Filament\Schemas\Components\Component>
     */
    #[\Override]
    protected function getInfolistSchema(): array
    {
        return app(AppointmentInfolist::class)->getInfolistSchema();
    }
=======
>>>>>>> laraxot/dev
}
