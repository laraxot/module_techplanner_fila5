<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Telefonanrufe',
        'name' => 'Telefonanruf',
        'plural' => 'Telefonanrufe',
        'group' => [
            'name' => 'Admin',
        ],
        'sort' => 51,
        'icon' => 'techplanner-phone-call',
    ],
    'enums' => [
        'inbound' => [
            'label' => 'Eingehend',
            'color' => 'success',
            'icon' => 'heroicon-o-arrow-down',
        ],
        'outbound' => [
            'label' => 'Ausgehend',
            'color' => 'warning',
            'icon' => 'heroicon-o-arrow-up',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Erstellen',
        ],
        'import' => [
            'label' => 'Importieren',
        ],
        'importClient' => [
            'label' => 'Kunde importieren',
        ],
    ],
    'fields' => [
        'date' => [
            'label' => 'Datum',
        ],
        'duration' => [
            'label' => 'Dauer',
        ],
        'notes' => [
            'label' => 'Notizen',
            'description' => 'notes',
        ],
        'call_type' => [
            'label' => 'Anruftyp',
            'description' => 'call_type',
            'helper_text' => 'call_type',
        ],
        'id' => [
            'label' => 'ID',
        ],
        'business_closed' => [
            'label' => 'Geschlossen',
        ],
        'company_name' => [
            'label' => 'Firmenname',
        ],
        'latitude' => [
            'label' => 'Breitengrad',
        ],
        'longitude' => [
            'label' => 'Längengrad',
        ],
        'distance' => [
            'label' => 'Entfernung',
        ],
        'distance_km' => [
            'label' => 'Entfernung (km)',
        ],
        'is_active' => [
            'label' => 'Aktiv',
        ],
        'full_address' => [
            'label' => 'Vollständige Adresse',
        ],
        'country' => [
            'label' => 'Land',
        ],
        'fiscal_code' => [
            'label' => 'Steuerliche Identifikationsnummer',
        ],
        'competent_health_unit' => [
            'label' => 'Zuständige Gesundheitsbehörde',
        ],
        'tax_code' => [
            'label' => 'Firmensteuercode',
        ],
        'vat_number' => [
            'label' => 'USt-IdNr.',
        ],
        'company_office' => [
            'label' => 'Firmensitz',
        ],
        'address' => [
            'label' => 'Adresse',
        ],
        'street_number' => [
            'label' => 'Hausnummer',
        ],
        'province' => [
            'label' => 'Provinz',
        ],
        'postal_code' => [
            'label' => 'Postleitzahl',
        ],
        'phone' => [
            'label' => 'Telefon',
        ],
        'fax' => [
            'label' => 'Fax',
        ],
        'mobile' => [
            'label' => 'Mobil',
        ],
        'email' => [
            'label' => 'E-Mail',
        ],
        'activity' => [
            'label' => 'Aktivität',
        ],
        'name' => [
            'label' => 'Name',
        ],
        'city' => [
            'label' => 'Stadt',
        ],
        'toggleColumns' => [
            'label' => 'Spalten umschalten',
        ],
        'reorderRecords' => [
            'label' => 'Datensätze neu ordnen',
        ],
        'detach' => [
            'label' => 'Trennen',
        ],
        'resetFilters' => [
            'label' => 'Filter zurücksetzen',
        ],
        'applyFilters' => [
            'label' => 'Filter anwenden',
        ],
        'openFilters' => [
            'label' => 'Filter öffnen',
        ],
        'edit' => [
            'label' => 'Bearbeiten',
        ],
        'view' => [
            'label' => 'Anzeigen',
        ],
        'attach' => [
            'label' => 'Anhängen',
        ],
        'create' => [
            'label' => 'Erstellen',
        ],
        'delete' => [
            'label' => 'Löschen',
        ],
        'layout' => [
            'label' => 'layout',
        ],
    ],
    'import' => [
        'label' => 'Daten importieren',
        'name' => [
            'label' => 'Name',
        ],
        'vat_number' => [
            'label' => 'USt-IdNr.',
        ],
        'fiscal_code' => [
            'label' => 'Steuerliche Identifikationsnummer',
        ],
        'city' => [
            'label' => 'Stadt',
        ],
        'province' => [
            'label' => 'Provinz',
        ],
        'phone' => [
            'label' => 'Telefon',
        ],
        'email' => [
            'label' => 'E-Mail',
        ],
        'is_active' => [
            'label' => 'Aktiv',
        ],
        'created_at' => [
            'label' => 'Erstellungsdatum',
        ],
        'updated_at' => [
            'label' => 'Letzte Änderung',
        ],
        'view' => [
            'label' => 'Anzeigen',
        ],
        'edit' => [
            'label' => 'Bearbeiten',
        ],
        'activity' => [
            'label' => 'Aktivität',
        ],
    ],
    'model' => [
        'label' => 'Telefonanruf',
    ],
];
