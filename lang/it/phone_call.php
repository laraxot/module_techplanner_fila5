<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Chiamate',
        'name' => 'Chiamata',
        'plural' => 'Chiamate',
        'group' => [
            'name' => 'Admin',
        ],
        'sort' => 51,
        'icon' => 'techplanner-phone-call',
    ],
    'enums' => [
        'inbound' => [
            'label' => 'Entrata',
            'color' => 'success',
            'icon' => 'heroicon-o-arrow-down',
        ],
        'outbound' => [
            'label' => 'Uscita',
            'color' => 'warning',
            'icon' => 'heroicon-o-arrow-up',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'import' => [
            'label' => 'Importa',
        ],
        'importClient' => [
            'label' => 'Importa Cliente',
        ],
        'cancel' => [
            'tooltip' => 'cancel',
            'label' => 'cancel',
            'icon' => 'cancel',
        ],
        'reorderRecords' => [
            'tooltip' => 'reorderRecords',
            'icon' => 'reorderRecords',
            'label' => 'reorderRecords',
        ],
        'openColumnManager' => [
            'tooltip' => 'openColumnManager',
            'icon' => 'openColumnManager',
            'label' => 'openColumnManager',
        ],
        'edit' => [
            'label' => 'edit',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'detach' => [
            'label' => 'detach',
            'icon' => 'detach',
            'tooltip' => 'detach',
        ],
        'delete' => [
            'label' => 'delete',
            'icon' => 'delete',
            'tooltip' => 'delete',
        ],
        'attach' => [
            'label' => 'attach',
            'icon' => 'attach',
            'tooltip' => 'attach',
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
        'submit' => [
            'label' => 'submit',
            'icon' => 'submit',
            'tooltip' => 'submit',
        ],
        'createAnother' => [
            'label' => 'createAnother',
            'icon' => 'createAnother',
            'tooltip' => 'createAnother',
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
    ],
    'fields' => [
        'date' => [
            'label' => 'Data',
            'placeholder' => 'date',
            'helper_text' => 'date',
            'description' => 'date',
        ],
        'duration' => [
            'label' => 'Durata',
            'placeholder' => 'duration',
            'helper_text' => 'duration',
            'description' => 'duration',
        ],
        'notes' => [
            'label' => 'Note',
            'description' => 'notes',
            'placeholder' => 'notes',
            'helper_text' => 'notes',
        ],
        'call_type' => [
            'label' => 'Tipo Chiamata',
            'description' => 'call_type',
            'helper_text' => 'call_type',
            'placeholder' => 'call_type',
        ],
        'id' => [
            'label' => 'ID',
        ],
        'business_closed' => [
            'label' => 'Cessato',
        ],
        'company_name' => [
            'label' => 'Nome Azienda',
        ],
        'latitude' => [
            'label' => 'Latitudine',
        ],
        'longitude' => [
            'label' => 'Longitudine',
        ],
        'distance' => [
            'label' => 'Distanza',
        ],
        'distance_km' => [
            'label' => 'Distanza (km)',
        ],
        'is_active' => [
            'label' => 'Attivo',
        ],
        'full_address' => [
            'label' => 'Indirizzo Completo',
        ],
        'country' => [
            'label' => 'Paese',
        ],
        'fiscal_code' => [
            'label' => 'Codice Fiscale',
        ],
        'competent_health_unit' => [
            'label' => 'Unità Sanitaria Competente',
        ],
        'tax_code' => [
            'label' => 'Codice Fiscale Azienda',
        ],
        'vat_number' => [
            'label' => 'Partita IVA',
        ],
        'company_office' => [
            'label' => 'Sede Azienda',
        ],
        'address' => [
            'label' => 'Indirizzo',
        ],
        'street_number' => [
            'label' => 'Numero Civico',
        ],
        'province' => [
            'label' => 'Provincia',
        ],
        'postal_code' => [
            'label' => 'CAP',
        ],
        'phone' => [
            'label' => 'Telefono',
        ],
        'fax' => [
            'label' => 'Fax',
        ],
        'mobile' => [
            'label' => 'Cellulare',
        ],
        'email' => [
            'label' => 'Email',
        ],
        'activity' => [
            'label' => 'Attività',
        ],
        'name' => [
            'label' => 'Nome',
        ],
        'city' => [
            'label' => 'Città',
        ],
        'toggleColumns' => [
            'label' => 'Attiva/Disattiva Colonne',
        ],
        'reorderRecords' => [
            'label' => 'Riorganizza Record',
        ],
        'detach' => [
            'label' => 'Separa',
        ],
        'resetFilters' => [
            'label' => 'Resetta Filtri',
        ],
        'applyFilters' => [
            'label' => 'Applica Filtri',
        ],
        'openFilters' => [
            'label' => 'Apri Filtri',
        ],
        'edit' => [
            'label' => 'Modifica',
        ],
        'view' => [
            'label' => 'Visualizza',
        ],
        'attach' => [
            'label' => 'Allega',
        ],
        'create' => [
            'label' => 'Crea',
        ],
        'delete' => [
            'label' => 'Elimina',
        ],
        'layout' => [
            'label' => 'layout',
        ],
    ],
    'import' => [
        'label' => 'Importa Dati',
        'name' => [
            'label' => 'Nome',
        ],
        'vat_number' => [
            'label' => 'Partita IVA',
        ],
        'fiscal_code' => [
            'label' => 'Codice Fiscale',
        ],
        'city' => [
            'label' => 'Città',
        ],
        'province' => [
            'label' => 'Provincia',
        ],
        'phone' => [
            'label' => 'Telefono',
        ],
        'email' => [
            'label' => 'Email',
        ],
        'is_active' => [
            'label' => 'Attivo',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
        ],
        'view' => [
            'label' => 'Visualizza',
        ],
        'edit' => [
            'label' => 'Modifica',
        ],
        'activity' => [
            'label' => 'Attività',
        ],
    ],
    'model' => [
        'label' => 'Chiamata',
    ],
    'label' => 'phone call',
];
