<?php

declare(strict_types=1);

return [
    'fields' => [
        'client' => [
            'company_name' => [
                'label' => 'Cliente',
            ],
            'name' => [
                'label' => 'client.name',
            ],
        ],
        'date' => [
            'label' => 'Data e ora',
        ],
        'notes' => [
            'label' => 'Note',
        ],
        'created_at' => [
            'label' => 'Creato il',
        ],
        'updated_at' => [
            'label' => 'Modificato il',
        ],
        'trashed' => [
            'label' => 'Record eliminati',
        ],
        'worker' => [
            'full_name' => [
                'label' => 'Tecnico',
            ],
        ],
        'duration_minutes' => [
            'label' => 'Durata (minuti)',
        ],
        'status' => [
            'label' => 'Stato',
        ],
        'worker_id' => [
            'label' => 'Tecnico',
        ],
        'date_range' => [
            'label' => 'Periodo',
        ],
        'from' => [
            'label' => 'Dal',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'until' => [
            'label' => 'Fino al',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
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
