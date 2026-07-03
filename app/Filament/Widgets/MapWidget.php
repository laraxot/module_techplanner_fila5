<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Widgets;

use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class MapWidget extends XotBaseWidget
{
    protected string $view = 'techplanner::filament.widgets.map';

    // Optional: Widget configuration
    protected int|string|array $columnSpan = 'full';

    /**
     * @return array<string, Component>
     */
    public function getFormSchema(): array
    {
        return [];
    }

    /**
     * Pass data to the widget view.
     */
    protected function getViewData(): array
    {
        return [
            'locations' => $this->getLocations(),
        ];
    }

    /**
     * Get locations for the map.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function getLocations(): array
    {
        // Implement your location fetching logic here
        return [];
    }
}
