<?php

declare(strict_types=1);

return [
    'enums' => [
        'scheduled' => [
            'label' => 'Scheduled',
            'color' => 'gray',
            'icon' => 'heroicon-o-calendar',
        ],
        'confirmed' => [
            'label' => 'Confirmed',
            'color' => 'info',
            'icon' => 'heroicon-o-check-badge',
        ],
        'in_progress' => [
            'label' => 'In progress',
            'color' => 'warning',
            'icon' => 'heroicon-o-arrow-path',
        ],
        'completed' => [
            'label' => 'Completed',
            'color' => 'success',
            'icon' => 'heroicon-o-check-circle',
        ],
        'cancelled' => [
            'label' => 'Cancelled',
            'color' => 'danger',
            'icon' => 'heroicon-o-x-circle',
        ],
        'no_show' => [
            'label' => 'No show',
            'color' => 'danger',
            'icon' => 'heroicon-o-user-minus',
        ],
    ],
];
