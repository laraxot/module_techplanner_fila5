<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\PhoneCallResource\Pages;

use Modules\TechPlanner\Filament\Resources\PhoneCallResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
<<<<<<< HEAD
use Modules\TechPlanner\Filament\Resources\PhoneCallResource\Schemas\PhoneCallInfolist;
=======
>>>>>>> laraxot/dev

class ViewPhoneCall extends XotBaseViewRecord
{
    protected static string $resource = PhoneCallResource::class;
<<<<<<< HEAD

    /**
     * @return array<string, \Filament\Schemas\Components\Component>
     */
    #[\Override]
    protected function getInfolistSchema(): array
    {
        return app(PhoneCallInfolist::class)->getInfolistSchema();
    }
=======
>>>>>>> laraxot/dev
}
