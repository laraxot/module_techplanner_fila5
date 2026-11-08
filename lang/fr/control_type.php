<?php

declare(strict_types=1);

return [
    'enums' => [
        'rx' => [
            'label' => 'Rayons X',
            'color' => 'primary',
            'icon' => 'heroicon-o-beaker',
        ],
        'intraoral' => [
            'label' => 'Contrôle intraoral',
            'color' => 'info',
            'icon' => 'heroicon-o-eye',
        ],
        'health_authorization' => [
            'label' => 'Autorisation sanitaire',
            'color' => 'success',
            'icon' => 'heroicon-o-shield-check',
        ],
        'electromedical' => [
            'label' => 'Contrôle électromédical',
            'color' => 'warning',
            'icon' => 'heroicon-o-cpu-chip',
        ],
        'other' => [
            'label' => 'Autre contrôle',
            'color' => 'gray',
            'icon' => 'heroicon-o-clipboard-document-list',
        ],
    ],
];
