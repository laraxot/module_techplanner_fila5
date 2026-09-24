<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\PhoneCallResource\Pages;

use Modules\TechPlanner\Filament\Resources\PhoneCallResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Modules\TechPlanner\Filament\Resources\PhoneCallResource\Schemas\PhoneCallInfolist;

class ViewPhoneCall extends XotBaseViewRecord
{
    protected static string $resource = PhoneCallResource::class;

    /**
     * @return array<string, \Filament\Schemas\Components\Component>
     */
    protected function getInfolistSchema(): array
    {
        return app(PhoneCallInfolist::class)->getInfolistSchema();
    }
}
