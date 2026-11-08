<?php

declare(strict_types=1);

return [
    'enums' => [
        'scheduled' => [
            'label' => 'Programmato',
            'color' => 'gray',
            'icon' => 'heroicon-o-calendar',
        ],
        'confirmed' => [
            'label' => 'Confermato',
            'color' => 'info',
            'icon' => 'heroicon-o-check-badge',
        ],
        'in_progress' => [
            'label' => 'In corso',
            'color' => 'warning',
            'icon' => 'heroicon-o-arrow-path',
        ],
        'completed' => [
            'label' => 'Completato',
            'color' => 'success',
            'icon' => 'heroicon-o-check-circle',
        ],
        'cancelled' => [
            'label' => 'Annullato',
            'color' => 'danger',
            'icon' => 'heroicon-o-x-circle',
        ],
        'no_show' => [
            'label' => 'Mancata presentazione',
            'color' => 'danger',
            'icon' => 'heroicon-o-user-minus',
        ],
    ],
];
