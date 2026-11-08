<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\Pages;

use Filament\Schemas\Components\Component;
use Modules\TechPlanner\Filament\Resources\DeviceResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewDevice extends XotBaseViewRecord
{
    protected static string $resource = DeviceResource::class;

    /**
     * @return array<string, Component>
     */
    protected function getInfolistSchema(): array
    {
        return [];
    }
}
