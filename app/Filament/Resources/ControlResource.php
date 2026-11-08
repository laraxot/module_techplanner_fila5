<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources;

use Modules\TechPlanner\Models\Control;
use Modules\Xot\Filament\Resources\XotBaseResource;

class ControlResource extends XotBaseResource
{
    protected static ?string $model = Control::class;
}
