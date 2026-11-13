<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => 'techplanner',
        'label' => 'Controlli',
        'icon' => 'techplanner-control',
        'sort' => 40,
    ],
    'fields' => [
        'client_id' => [
            'label' => 'Cliente',
        ],
        'device_id' => [
            'label' => 'Dispositivo',
        ],
        'worker_id' => [
            'label' => 'Tecnico',
        ],
        'appointment_id' => [
            'label' => 'Appuntamento',
        ],
        'control_type' => [
            'label' => 'Tipo di controllo',
        ],
        'status' => [
            'label' => 'Stato',
        ],
        'result' => [
            'label' => 'Esito',
        ],
        'control_date' => [
            'label' => 'Data controllo',
        ],
        'next_control_date' => [
            'label' => 'Prossimo controllo',
        ],
        'notes' => [
            'label' => 'Note',
        ],
        'value' => [
            'label' => 'Valore',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'filters' => [
        'schedule_status' => [
            'label' => 'Stato pianificazione',
            'value' => 'Stato',
        ],
        'expiring' => [
            'label' => 'In scadenza (30 gg)',
        ],
        'expired' => [
            'label' => 'Scaduti',
        ],
    ],
    'widget' => [
        'heading' => 'Controlli in scadenza',
        'expired' => 'Scaduti',
        'expiring' => 'In scadenza (30 gg)',
        'unplanned' => 'Senza prossima data',
        'clients_affected' => 'Clienti interessati',
    ],
    'reminder' => [
        'subject' => 'Controlli in scadenza',
        'body' => ':count controlli in scadenza entro il :date (:expired scaduti).',
        'action_text' => 'Vedi controlli',
    ],
    'actions' => [
        'create' => [
            'label' => 'create',
            'icon' => 'create',
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
        'reorderRecords' => [
            'label' => 'reorderRecords',
            'icon' => 'reorderRecords',
            'tooltip' => '',
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
        'createAnother' => [
            'label' => 'createAnother',
            'icon' => 'createAnother',
            'tooltip' => '',
        ],
        'cancel' => [
            'label' => 'cancel',
            'icon' => 'cancel',
            'tooltip' => '',
        ],
        'add' => [
            'label' => 'add',
            'icon' => 'add',
            'tooltip' => '',
        ],
        'addBetween' => [
            'label' => 'addBetween',
            'icon' => 'addBetween',
            'tooltip' => '',
        ],
        'clone' => [
            'label' => 'clone',
            'icon' => 'clone',
            'tooltip' => '',
        ],
        'collapse' => [
            'label' => 'collapse',
            'icon' => 'collapse',
            'tooltip' => '',
        ],
        'collapseAll' => [
            'label' => 'collapseAll',
            'icon' => 'collapseAll',
            'tooltip' => '',
        ],
        'delete' => [
            'label' => 'delete',
            'icon' => 'delete',
            'tooltip' => '',
        ],
        'expand' => [
            'label' => 'expand',
            'icon' => 'expand',
            'tooltip' => '',
        ],
        'expandAll' => [
            'label' => 'expandAll',
            'icon' => 'expandAll',
            'tooltip' => '',
        ],
        'moveDown' => [
            'label' => 'moveDown',
            'icon' => 'moveDown',
            'tooltip' => '',
        ],
        'moveUp' => [
            'label' => 'moveUp',
            'icon' => 'moveUp',
            'tooltip' => '',
        ],
        'reorder' => [
            'label' => 'reorder',
            'icon' => 'reorder',
            'tooltip' => '',
        ],
    ],
    'label' => 'control',
];
