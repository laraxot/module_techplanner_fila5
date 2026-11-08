<?php

declare(strict_types=1);

return [
    'enums' => [
        'rx' => [
            'label' => 'Rayos X',
            'color' => 'primary',
            'icon' => 'heroicon-o-beaker',
        ],
        'intraoral' => [
            'label' => 'Control intraoral',
            'color' => 'info',
            'icon' => 'heroicon-o-eye',
        ],
        'health_authorization' => [
            'label' => 'Autorizzación sanitaria',
            'color' => 'success',
            'icon' => 'heroicon-o-shield-check',
        ],
        'electromedical' => [
            'label' => 'Control electromédico',
            'color' => 'warning',
            'icon' => 'heroicon-o-cpu-chip',
        ],
        'other' => [
            'label' => 'Otro control',
            'color' => 'gray',
            'icon' => 'heroicon-o-clipboard-document-list',
        ],
    ],
];
