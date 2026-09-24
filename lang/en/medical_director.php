<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => 'techplanner',
        'label' => 'Medical Directors',
        'icon' => 'techplanner-medical-director',
        'sort' => 40,
    ],
    'fields' => [
        'name' => [
            'label' => 'Name',
        ],
        'license_number' => [
            'label' => 'License Number',
        ],
        'specialization' => [
            'label' => 'Specialization',
        ],
        'email' => [
            'label' => 'Email',
        ],
        'phone' => [
            'label' => 'Phone',
        ],
        'license_expiry' => [
            'label' => 'License Expiry',
        ],
        'notes' => [
            'label' => 'Notes',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
    ],
    'model' => [
        'label' => 'Medical Director',
        'plural' => 'Medical Directors',
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
