<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\Pages;

use Modules\TechPlanner\Filament\Resources\DeviceResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateDevice extends XotBaseCreateRecord
{
    protected static string $resource = DeviceResource::class;
}
