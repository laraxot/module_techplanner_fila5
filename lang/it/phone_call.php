<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => 'Lavoro quotidiano',
        'label' => 'Chiamate',
        'plural_label' => 'Chiamate',
        'icon' => 'techplanner-phone-call',
        'sort' => 30,
        'name' => 'Chiamata',
        'plural' => 'Chiamate',
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
            'tooltip' => '',
        ],
        'import' => [
            'label' => 'Importa',
        ],
        'importClient' => [
            'label' => 'Importa Cliente',
        ],
        'cancel' => [
            'tooltip' => '',
            'label' => 'cancel',
            'icon' => 'cancel',
        ],
        'reorderRecords' => [
            'tooltip' => '',
            'icon' => 'reorderRecords',
            'label' => 'reorderRecords',
        ],
        'createAnother' => [
            'label' => 'createAnother',
            'icon' => 'createAnother',
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
        'edit' => [
            'label' => 'edit',
            'icon' => 'edit',
            'tooltip' => '',
        ],
        'detach' => [
            'label' => 'detach',
            'icon' => 'detach',
            'tooltip' => '',
        ],
        'delete' => [
            'label' => 'delete',
            'icon' => 'delete',
            'tooltip' => '',
        ],
        'attach' => [
            'label' => 'attach',
            'icon' => 'attach',
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
        'submit' => [
            'label' => 'submit',
            'icon' => 'submit',
            'tooltip' => '',
        ],
        'back' => [
            'label' => 'back',
            'icon' => 'back',
            'tooltip' => '',
        ],
        'save' => [
            'label' => 'save',
            'icon' => 'save',
            'tooltip' => '',
        ],
    ],
    'fields' => [
        'date' => [
            'label' => 'Data',
            'placeholder' => '',
            'helper_text' => '',
            'description' => 'date',
        ],
        'duration' => [
            'label' => 'Durata',
            'placeholder' => '',
            'helper_text' => '',
            'description' => 'duration',
        ],
        'notes' => [
            'label' => 'Note',
            'description' => 'notes',
            'placeholder' => '',
            'helper_text' => '',
        ],
        'call_type' => [
            'label' => 'Tipo Chiamata',
            'description' => 'call_type',
            'helper_text' => '',
            'placeholder' => '',
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
        'value' => [
            'label' => 'Valore',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
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
    'label' => 'Chiamata',
    'plural_label' => 'Chiamate',
];
