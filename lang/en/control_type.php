<?php

declare(strict_types=1);

return [
    'enums' => [
        'rx' => [
            'label' => 'X-Ray',
            'color' => 'primary',
            'icon' => 'heroicon-o-beaker',
        ],
        'intraoral' => [
            'label' => 'Intraoral check',
            'color' => 'info',
            'icon' => 'heroicon-o-eye',
        ],
        'health_authorization' => [
            'label' => 'Health authorization',
            'color' => 'success',
            'icon' => 'heroicon-o-shield-check',
        ],
        'electromedical' => [
            'label' => 'Electromedical inspection',
            'color' => 'warning',
            'icon' => 'heroicon-o-cpu-chip',
        ],
        'other' => [
            'label' => 'Other check',
            'color' => 'gray',
            'icon' => 'heroicon-o-clipboard-document-list',
        ],
    ],
];
