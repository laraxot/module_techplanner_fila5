<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\PhoneCallResource\Pages;

use Filament\Schemas\Components\Component;
use Modules\TechPlanner\Filament\Resources\PhoneCallResource;
use Modules\TechPlanner\Filament\Resources\PhoneCallResource\Schemas\PhoneCallInfolist;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewPhoneCall extends XotBaseViewRecord
{
    protected static string $resource = PhoneCallResource::class;

    /**
     * @return array<string, Component>
     */
    protected function getInfolistSchema(): array
    {
        return app(PhoneCallInfolist::class)->getInfolistSchema();
    }
}
