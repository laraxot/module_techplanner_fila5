<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => 'techplanner',
        'label' => 'Dispositivi',
        'icon' => 'techplanner-device',
        'sort' => 20,
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Nome',
        ],
        'serial_number' => [
            'label' => 'Numero Seriale',
        ],
        'model' => [
            'label' => 'Modello',
        ],
        'manufacturer' => [
            'label' => 'Produttore',
        ],
        'purchase_date' => [
            'label' => 'Data Acquisto',
        ],
        'warranty_expiration' => [
            'label' => 'Scadenza Garanzia',
        ],
        'notes' => [
            'label' => 'Note',
        ],
        'client' => [
            'name' => [
                'label' => 'Nome Cliente',
            ],
        ],
        'client_id' => [
            'label' => 'Cliente',
        ],
        'type' => [
            'label' => 'Tipo',
        ],
        'brand' => [
            'label' => 'Marca',
        ],
        'status' => [
            'label' => 'Stato',
        ],
        'description' => [
            'label' => 'Descrizione',
        ],
        'headset_serial' => [
            'label' => 'Matricola Cuffia',
        ],
        'tube_serial' => [
            'label' => 'Matricola Tubo',
        ],
        'kv' => [
            'label' => 'KV',
        ],
        'ma' => [
            'label' => 'mA',
        ],
        'first_verification_date' => [
            'label' => 'Data Prima Verifica',
        ],
        'warranty_expiry' => [
            'label' => 'Scadenza Garanzia',
        ],
        'created_at' => [
            'label' => 'Creato Il',
        ],
        'updated_at' => [
            'label' => 'Aggiornato Il',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
    ],
    'sections' => [
        'base_info' => [
            'label' => 'Informazioni Base',
        ],
        'additional_details' => [
            'label' => 'Dettagli Aggiuntivi',
        ],
        'dates' => [
            'label' => 'Date',
        ],
        'more_info' => [
            'label' => 'Informazioni Aggiuntive',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo Dispositivo',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'edit' => [
            'label' => 'Modifica Dispositivo',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'delete' => [
            'label' => 'Elimina Dispositivo',
            'icon' => 'delete',
            'tooltip' => 'delete',
        ],
        'downloadExample' => [
            'label' => 'downloadExample',
            'icon' => 'downloadExample',
            'tooltip' => 'downloadExample',
        ],
        'reorderRecords' => [
            'tooltip' => 'reorderRecords',
            'icon' => 'reorderRecords',
            'label' => 'reorderRecords',
        ],
        'cancel' => [
            'tooltip' => 'cancel',
            'label' => 'cancel',
            'icon' => 'cancel',
        ],
        'importDevice' => [
            'label' => 'importDevice',
            'icon' => 'importDevice',
            'tooltip' => 'importDevice',
        ],
        'view' => [
            'label' => 'view',
            'icon' => 'view',
            'tooltip' => 'view',
        ],
        'layout' => [
            'label' => 'layout',
            'icon' => 'layout',
            'tooltip' => 'layout',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
            'icon' => 'applyFilters',
            'tooltip' => 'applyFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
            'icon' => 'openFilters',
            'tooltip' => 'openFilters',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
            'icon' => 'resetFilters',
            'tooltip' => 'resetFilters',
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
        'resetColumnManager' => [
            'label' => 'resetColumnManager',
            'icon' => 'resetColumnManager',
            'tooltip' => 'resetColumnManager',
        ],
        'createAnother' => [
            'label' => 'createAnother',
            'icon' => 'createAnother',
            'tooltip' => 'createAnother',
        ],
    ],
    'messages' => [
        'created' => 'Dispositivo creato con successo',
        'updated' => 'Dispositivo aggiornato con successo',
        'deleted' => 'Dispositivo eliminato con successo',
    ],
    'model' => [
        'label' => 'Dispositivo',
        'plural' => 'Dispositivi',
    ],
    'label' => 'device',
];
