<?php

declare(strict_types=1);

return [
    'enums' => [
        'rx' => [
            'label' => 'Röntgen',
            'color' => 'primary',
            'icon' => 'heroicon-o-beaker',
        ],
        'intraoral' => [
            'label' => 'Intraorale Kontrolle',
            'color' => 'info',
            'icon' => 'heroicon-o-eye',
        ],
        'health_authorization' => [
            'label' => 'Gesundheitliche Genehmigung',
            'color' => 'success',
            'icon' => 'heroicon-o-shield-check',
        ],
        'electromedical' => [
            'label' => 'Elektromedizinische Prüfung',
            'color' => 'warning',
            'icon' => 'heroicon-o-cpu-chip',
        ],
        'other' => [
            'label' => 'Sonstige Kontrolle',
            'color' => 'gray',
            'icon' => 'heroicon-o-clipboard-document-list',
        ],
    ],
];
