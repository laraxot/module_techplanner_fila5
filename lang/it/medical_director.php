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
    ],
    'model' => [
        'label' => 'Direttore Sanitario',
        'plural' => 'Direttori Sanitari',
    ],
    'actions' => [
        'downloadExample' => [
            'label' => 'downloadExample',
        ],
        'importMedicalDirector' => [
            'label' => 'importMedicalDirector',
        ],
        'reorderRecords' => [
            'tooltip' => 'reorderRecords',
        ],
    ],
    'label' => 'medical director',
];
