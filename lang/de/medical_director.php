<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => 'techplanner',
        'label' => 'Medizinische Direktoren',
        'icon' => 'techplanner-medical-director',
        'sort' => 40,
    ],
    'fields' => [
        'name' => [
            'label' => 'Name',
        ],
        'license_number' => [
            'label' => 'Lizenznummer',
        ],
        'specialization' => [
            'label' => 'Spezialisierung',
        ],
        'email' => [
            'label' => 'E-Mail',
        ],
        'phone' => [
            'label' => 'Telefon',
        ],
        'license_expiry' => [
            'label' => 'Lizenzablauf',
        ],
        'notes' => [
            'label' => 'Notizen',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
    ],
    'model' => [
        'label' => 'Medizinischer Direktor',
        'plural' => 'Medizinische Direktoren',
    ],
    'actions' => [
        'downloadExample' => [
            'label' => 'downloadExample',
        ],
        'importMedicalDirector' => [
            'label' => 'importMedicalDirector',
        ],
    ],
];
