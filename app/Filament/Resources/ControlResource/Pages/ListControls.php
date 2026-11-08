<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ControlResource\Pages;

use Modules\TechPlanner\Filament\Resources\ControlResource;
use Modules\TechPlanner\Filament\Widgets\ExpiringControlsWidget;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListControls extends XotBaseListRecords
{
    protected static string $resource = ControlResource::class;

    /**
     * @return array<int, string>
     */
    protected function getHeaderWidgets(): array
    {
        return [
            ExpiringControlsWidget::class,
        ];
    }
}
