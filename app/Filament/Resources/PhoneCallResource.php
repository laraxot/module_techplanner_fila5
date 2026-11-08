<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources;

use Modules\TechPlanner\Models\PhoneCall;
use Modules\Xot\Filament\Resources\XotBaseResource;

class PhoneCallResource extends XotBaseResource
{
    protected static ?string $model = PhoneCall::class;
}
