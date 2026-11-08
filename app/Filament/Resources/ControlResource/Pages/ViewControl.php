<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ControlResource\Pages;

use Modules\TechPlanner\Filament\Resources\ControlResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewControl extends XotBaseViewRecord
{
    protected static string $resource = ControlResource::class;
}
