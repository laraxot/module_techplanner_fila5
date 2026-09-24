<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => 'techplanner',
        'label' => 'Geräte',
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
            'label' => 'Seriennummer',
        ],
        'model' => [
            'label' => 'Modell',
        ],
        'manufacturer' => [
            'label' => 'Hersteller',
        ],
        'purchase_date' => [
            'label' => 'Kaufdatum',
        ],
        'warranty_expiration' => [
            'label' => 'Garantieablauf',
        ],
        'notes' => [
            'label' => 'Notizen',
        ],
        'client' => [
            'name' => [
                'label' => 'Kundenname',
            ],
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Neues Gerät',
        ],
        'edit' => [
            'label' => 'Gerät bearbeiten',
        ],
        'delete' => [
            'label' => 'Gerät löschen',
        ],
        'downloadExample' => [
            'label' => 'downloadExample',
        ],
    ],
    'messages' => [
        'created' => 'Gerät erfolgreich erstellt',
        'updated' => 'Gerät erfolgreich aktualisiert',
        'deleted' => 'Gerät erfolgreich gelöscht',
    ],
    'model' => [
        'label' => 'Gerät',
        'plural' => 'Geräte',
    ],
];
