<?php

declare(strict_types=1);

return [
    'fields' => [
        'client' => [
            'company_name' => [
                'label' => 'Cliente',
            ],
        ],
        'type' => [
            'label' => 'Tipo',
        ],
        'brand' => [
            'label' => 'Marca',
        ],
        'model' => [
            'label' => 'Modello',
        ],
        'headset_serial' => [
            'label' => 'Matricola cuffia',
        ],
        'tube_serial' => [
            'label' => 'Matricola tubo',
        ],
        'kv' => [
            'label' => 'kV',
        ],
        'ma' => [
            'label' => 'mA',
        ],
        'first_verification_date' => [
            'label' => 'Prima verifica',
        ],
        'next_verification_date' => [
            'label' => 'Prossima verifica',
        ],
        'notes' => [
            'label' => 'Note',
        ],
        'due' => [
            'label' => 'Scadenza verifica',
        ],
        'trashed' => [
            'label' => 'Record eliminati',
        ],
        'controls_count' => [
            'label' => 'Controlli',
        ],
    ],
    'filters' => [
        'due' => [
            'label' => 'Scadenza verifica',
            'options' => [
                'overdue' => 'Scadute',
                30 => 'Entro 30 giorni',
                60 => 'Entro 60 giorni',
                90 => 'Entro 90 giorni',
                'never' => 'Mai verificati',
            ],
        ],
        'trashed' => [
            'label' => 'Record eliminati',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'create',
            'icon' => 'create',
            'tooltip' => '',
        ],
        'layout' => [
            'label' => 'layout',
            'icon' => 'layout',
            'tooltip' => '',
        ],
        'view' => [
            'label' => 'view',
            'icon' => 'view',
            'tooltip' => '',
        ],
        'edit' => [
            'label' => 'edit',
            'icon' => 'edit',
            'tooltip' => '',
        ],
        'delete' => [
            'label' => 'delete',
            'icon' => 'delete',
            'tooltip' => '',
        ],
        'restore' => [
            'label' => 'restore',
            'icon' => 'restore',
            'tooltip' => '',
        ],
        'forceDelete' => [
            'label' => 'forceDelete',
            'icon' => 'forceDelete',
            'tooltip' => '',
        ],
    ],
];
