<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ControlResource\Pages;

use Modules\TechPlanner\Filament\Resources\ControlResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateControl extends XotBaseCreateRecord
{
    protected static string $resource = ControlResource::class;
}
