<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => 'techplanner',
        'label' => 'Devices',
        'icon' => 'techplanner-device',
        'sort' => 20,
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Name',
        ],
        'serial_number' => [
            'label' => 'Serial Number',
        ],
        'model' => [
            'label' => 'Model',
        ],
        'manufacturer' => [
            'label' => 'Manufacturer',
        ],
        'purchase_date' => [
            'label' => 'Purchase Date',
        ],
        'warranty_expiration' => [
            'label' => 'Warranty Expiration',
        ],
        'notes' => [
            'label' => 'Notes',
        ],
        'client' => [
            'name' => [
                'label' => 'Client Name',
            ],
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'New Device',
        ],
        'edit' => [
            'label' => 'Edit Device',
        ],
        'delete' => [
            'label' => 'Delete Device',
        ],
        'downloadExample' => [
            'label' => 'downloadExample',
        ],
    ],
    'messages' => [
        'created' => 'Device created successfully',
        'updated' => 'Device updated successfully',
        'deleted' => 'Device deleted successfully',
    ],
    'model' => [
        'label' => 'Device',
        'plural' => 'Devices',
    ],
];
