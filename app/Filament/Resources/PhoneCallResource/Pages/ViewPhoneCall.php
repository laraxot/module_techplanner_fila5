<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\PhoneCallResource\Pages;

use Modules\TechPlanner\Filament\Resources\PhoneCallResource;
use Modules\TechPlanner\Filament\Resources\PhoneCallResource\Schemas\PhoneCallInfolist;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Override;

class ViewPhoneCall extends XotBaseViewRecord
{
    protected static string $resource = PhoneCallResource::class;

    #[Override]
    protected function getInfolistSchema(): array
    {
        return PhoneCallInfolist::getInfolistSchema();
    }
}
