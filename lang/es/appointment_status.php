<?php

declare(strict_types=1);

return [
    'enums' => [
        'scheduled' => [
            'label' => 'Programado',
            'color' => 'gray',
            'icon' => 'heroicon-o-calendar',
        ],
        'confirmed' => [
            'label' => 'Confirmado',
            'color' => 'info',
            'icon' => 'heroicon-o-check-badge',
        ],
        'in_progress' => [
            'label' => 'En curso',
            'color' => 'warning',
            'icon' => 'heroicon-o-arrow-path',
        ],
        'completed' => [
            'label' => 'Completado',
            'color' => 'success',
            'icon' => 'heroicon-o-check-circle',
        ],
        'cancelled' => [
            'label' => 'Cancelado',
            'color' => 'danger',
            'icon' => 'heroicon-o-x-circle',
        ],
        'no_show' => [
            'label' => 'No presentado',
            'color' => 'danger',
            'icon' => 'heroicon-o-user-minus',
        ],
    ],
];
