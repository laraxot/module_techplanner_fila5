<?php

declare(strict_types=1);

use Modules\TechPlanner\Filament\Widgets\ClientMapWidget;
use Modules\TechPlanner\Filament\Widgets\CoordinatesWidget;

return [
    'widgets' => [
        'namespace' => 'Modules\\TechPlanner\\Filament\\Widgets',
        'path' => base_path('Modules/TechPlanner/app/Filament/Widgets'),
        'register' => [
            ClientMapWidget::class,
            CoordinatesWidget::class,
        ],
    ],
];
