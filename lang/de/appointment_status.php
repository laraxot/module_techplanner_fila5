<?php

declare(strict_types=1);

return [
    'enums' => [
        'scheduled' => [
            'label' => 'Geplant',
            'color' => 'gray',
            'icon' => 'heroicon-o-calendar',
        ],
        'confirmed' => [
            'label' => 'Bestätigt',
            'color' => 'info',
            'icon' => 'heroicon-o-check-badge',
        ],
        'in_progress' => [
            'label' => 'In Bearbeitung',
            'color' => 'warning',
            'icon' => 'heroicon-o-arrow-path',
        ],
        'completed' => [
            'label' => 'Abgeschlossen',
            'color' => 'success',
            'icon' => 'heroicon-o-check-circle',
        ],
        'cancelled' => [
            'label' => 'Storniert',
            'color' => 'danger',
            'icon' => 'heroicon-o-x-circle',
        ],
        'no_show' => [
            'label' => 'Nicht erschienen',
            'color' => 'danger',
            'icon' => 'heroicon-o-user-minus',
        ],
    ],
];
