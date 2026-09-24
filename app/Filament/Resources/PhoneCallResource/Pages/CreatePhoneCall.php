<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\PhoneCallResource\Pages;

use Modules\TechPlanner\Filament\Resources\PhoneCallResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreatePhoneCall extends XotBaseCreateRecord
{
    protected static string $resource = PhoneCallResource::class;
}
