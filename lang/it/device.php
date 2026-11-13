<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => 'Lavoro quotidiano',
        'label' => 'Apparecchi',
        'plural_label' => 'Apparecchi',
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
        'value' => [
            'label' => 'Valore',
            'placeholder' => '',
            'helper_text' => '',
            'description' => 'value',
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
            'tooltip' => '',
        ],
        'edit' => [
            'label' => 'Modifica Dispositivo',
            'icon' => 'edit',
            'tooltip' => '',
        ],
        'delete' => [
            'label' => 'Elimina Dispositivo',
            'icon' => 'delete',
            'tooltip' => '',
        ],
        'downloadExample' => [
            'label' => 'downloadExample',
            'icon' => 'downloadExample',
            'tooltip' => '',
        ],
        'reorderRecords' => [
            'tooltip' => '',
            'icon' => 'reorderRecords',
            'label' => 'reorderRecords',
        ],
        'cancel' => [
            'tooltip' => '',
            'label' => 'cancel',
            'icon' => 'cancel',
        ],
        'profile' => [
            'label' => 'profile',
            'icon' => 'profile',
            'tooltip' => '',
        ],
        'logout' => [
            'label' => 'logout',
            'icon' => 'logout',
            'tooltip' => '',
        ],
        'importDevice' => [
            'label' => 'Importa apparecchi',
            'icon' => 'importDevice',
            'tooltip' => '',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
            'icon' => 'applyFilters',
            'tooltip' => '',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
            'icon' => 'resetFilters',
            'tooltip' => '',
        ],
        'openFilters' => [
            'label' => 'openFilters',
            'icon' => 'openFilters',
            'tooltip' => '',
        ],
        'applyTableColumnManager' => [
            'label' => 'applyTableColumnManager',
            'icon' => 'applyTableColumnManager',
            'tooltip' => '',
        ],
        'openColumnManager' => [
            'label' => 'openColumnManager',
            'icon' => 'openColumnManager',
            'tooltip' => '',
        ],
        'resetColumnManager' => [
            'label' => 'resetColumnManager',
            'icon' => 'resetColumnManager',
            'tooltip' => '',
        ],
        'createAnother' => [
            'label' => 'createAnother',
            'icon' => 'createAnother',
            'tooltip' => '',
        ],
        'removeAllFilters' => [
            'label' => 'removeAllFilters',
            'icon' => 'removeAllFilters',
            'tooltip' => '',
        ],
        'view' => [
            'label' => 'view',
            'icon' => 'view',
            'tooltip' => '',
        ],
        'save' => [
            'label' => 'save',
            'icon' => 'save',
            'tooltip' => '',
        ],
        'layout' => [
            'label' => 'layout',
            'icon' => 'layout',
            'tooltip' => '',
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
    'label' => 'Apparecchio',
    'plural_label' => 'Apparecchi',
];
