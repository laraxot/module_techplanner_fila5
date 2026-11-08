<?php

declare(strict_types=1);

return [
    'enums' => [
        'rx' => [
            'label' => 'Raggi X',
            'color' => 'primary',
            'icon' => 'heroicon-o-beaker',
        ],
        'intraoral' => [
            'label' => 'Controllo endorale',
            'color' => 'info',
            'icon' => 'heroicon-o-eye',
        ],
        'health_authorization' => [
            'label' => 'Autorizzazione sanitaria',
            'color' => 'success',
            'icon' => 'heroicon-o-shield-check',
        ],
        'electromedical' => [
            'label' => 'Controllo elettromedicali',
            'color' => 'warning',
            'icon' => 'heroicon-o-cpu-chip',
        ],
        'other' => [
            'label' => 'Altro controllo',
            'color' => 'gray',
            'icon' => 'heroicon-o-clipboard-document-list',
        ],
    ],
];
