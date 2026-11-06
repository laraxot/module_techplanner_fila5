<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => 'techplanner',
        'label' => 'Direttori Sanitari',
        'icon' => 'techplanner-medical-director',
        'sort' => 40,
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
        ],
        'license_number' => [
            'label' => 'Numero Licenza',
        ],
        'specialization' => [
            'label' => 'Specializzazione',
        ],
        'email' => [
            'label' => 'Email',
        ],
        'phone' => [
            'label' => 'Telefono',
        ],
        'license_expiry' => [
            'label' => 'Scadenza Licenza',
        ],
        'notes' => [
            'label' => 'Note',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'created_at' => [
            'label' => 'created_at',
        ],
    ],
    'model' => [
        'label' => 'Direttore Sanitario',
        'plural' => 'Direttori Sanitari',
    ],
    'actions' => [
        'downloadExample' => [
            'label' => 'downloadExample',
            'icon' => 'downloadExample',
            'tooltip' => 'downloadExample',
        ],
        'importMedicalDirector' => [
            'label' => 'importMedicalDirector',
            'icon' => 'importMedicalDirector',
            'tooltip' => 'importMedicalDirector',
        ],
        'reorderRecords' => [
            'tooltip' => 'reorderRecords',
            'label' => 'reorderRecords',
            'icon' => 'reorderRecords',
        ],
        'create' => [
            'label' => 'create',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
            'icon' => 'applyFilters',
            'tooltip' => 'applyFilters',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
            'icon' => 'resetFilters',
            'tooltip' => 'resetFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
            'icon' => 'openFilters',
            'tooltip' => 'openFilters',
        ],
        'applyTableColumnManager' => [
            'label' => 'applyTableColumnManager',
            'icon' => 'applyTableColumnManager',
            'tooltip' => 'applyTableColumnManager',
        ],
        'openColumnManager' => [
            'label' => 'openColumnManager',
            'icon' => 'openColumnManager',
            'tooltip' => 'openColumnManager',
        ],
        'resetColumnManager' => [
            'label' => 'resetColumnManager',
            'icon' => 'resetColumnManager',
            'tooltip' => 'resetColumnManager',
        ],
        'profile' => [
            'label' => 'profile',
            'icon' => 'profile',
            'tooltip' => 'profile',
        ],
        'logout' => [
            'label' => 'logout',
            'icon' => 'logout',
            'tooltip' => 'logout',
        ],
        'removeAllFilters' => [
            'label' => 'removeAllFilters',
            'icon' => 'removeAllFilters',
            'tooltip' => 'removeAllFilters',
        ],
        'createAnother' => [
            'label' => 'createAnother',
            'icon' => 'createAnother',
            'tooltip' => 'createAnother',
        ],
        'cancel' => [
            'label' => 'cancel',
            'icon' => 'cancel',
            'tooltip' => 'cancel',
        ],
    ],
    'label' => 'medical director',
];
