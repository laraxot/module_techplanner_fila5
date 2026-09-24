<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => 'techplanner',
        'label' => 'Kunden',
        'icon' => 'techplanner-client',
        'sort' => 30,
    ],
    'actions' => [
        'create' => [
            'label' => 'Neuer Kunde',
        ],
        'import' => [
            'label' => 'Kunden importieren',
        ],
        'importClient' => [
            'label' => 'Kunden importieren',
        ],
        'populateCoordinates' => [
            'label' => 'Koordinaten aktualisieren',
        ],
        'updateCoordinates' => [
            'label' => 'Koordinaten aktualisieren',
        ],
        'sortByDistance' => [
            'label' => 'Nach Entfernung sortieren',
        ],
        'downloadExample' => [
            'label' => 'Beispiel herunterladen',
        ],
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'business_closed' => [
            'label' => 'Geschäft geschlossen',
            'description' => 'business_closed',
            'helper_text' => 'business_closed',
            'placeholder' => 'business_closed',
        ],
        'company_name' => [
            'label' => 'Firmenname',
            'description' => 'company_name',
            'helper_text' => 'company_name',
            'placeholder' => 'company_name',
        ],
        'latitude' => [
            'label' => 'Breitengrad',
            'description' => 'latitude',
            'helper_text' => 'latitude',
            'placeholder' => 'latitude',
        ],
        'longitude' => [
            'label' => 'Längengrad',
            'description' => 'longitude',
            'helper_text' => 'longitude',
            'placeholder' => 'longitude',
        ],
        'distance' => [
            'label' => 'Entfernung',
        ],
        'distance_km' => [
            'label' => 'km',
        ],
        'is_active' => [
            'label' => 'Aktiv',
        ],
        'full_address' => [
            'label' => 'Vollständige Adresse',
        ],
        'country' => [
            'label' => 'Land',
            'description' => 'country',
            'helper_text' => 'country',
            'placeholder' => 'country',
        ],
        'tax_code' => [
            'label' => 'Steuercode',
            'description' => 'tax_code',
            'helper_text' => 'tax_code',
            'placeholder' => 'tax_code',
        ],
        'vat_number' => [
            'label' => 'USt-IdNr.',
            'description' => 'vat_number',
            'helper_text' => 'vat_number',
            'placeholder' => 'vat_number',
        ],
        'fiscal_code' => [
            'label' => 'Steuerliche Identifikationsnummer',
            'description' => 'fiscal_code',
            'helper_text' => 'fiscal_code',
            'placeholder' => 'fiscal_code',
        ],
        'competent_health_unit' => [
            'label' => 'Zuständige Gesundheitsbehörde',
            'description' => 'competent_health_unit',
            'helper_text' => 'competent_health_unit',
            'placeholder' => 'competent_health_unit',
        ],
        'address' => [
            'label' => 'Adresse',
            'description' => 'address',
            'helper_text' => 'address',
            'placeholder' => 'address',
        ],
        'street_number' => [
            'label' => 'Hausnummer',
            'description' => 'street_number',
            'helper_text' => 'street_number',
            'placeholder' => 'street_number',
        ],
        'postal_code' => [
            'label' => 'Postleitzahl',
            'description' => 'postal_code',
            'helper_text' => 'postal_code',
            'placeholder' => 'postal_code',
        ],
        'province' => [
            'label' => 'Provinz',
            'description' => 'province',
            'helper_text' => 'province',
            'placeholder' => 'province',
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
        'notes' => [
            'label' => 'Notizen',
            'description' => 'notes',
            'helper_text' => 'notes',
            'placeholder' => 'notes',
        ],
        'activity' => [
            'label' => 'Aktivität',
            'description' => 'activity',
            'helper_text' => 'activity',
            'placeholder' => 'activity',
        ],
        'name' => [
            'label' => 'Name',
        ],
        'city' => [
            'label' => 'Stadt',
            'description' => 'city',
            'helper_text' => 'city',
            'placeholder' => 'city',
        ],
        'company_office' => [
            'label' => 'Firmensitz',
            'description' => 'company_office',
            'helper_text' => 'company_office',
            'placeholder' => 'company_office',
        ],
        'sortByDistance' => [
            'label' => 'Nach Entfernung sortieren',
        ],
        'toggleColumns' => [
            'label' => 'Spalten umschalten',
        ],
        'reorderRecords' => [
            'label' => 'Datensätze neu ordnen',
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
        'value' => [
            'label' => 'Wert',
            'description' => 'value',
            'helper_text' => 'value',
            'placeholder' => 'value',
        ],
        'delete' => [
            'label' => 'Löschen',
        ],
        'edit' => [
            'label' => 'Bearbeiten',
        ],
        'values' => [
            'label' => 'Werte',
            'description' => 'values',
            'helper_text' => 'values',
            'placeholder' => 'values',
        ],
        'view' => [
            'label' => 'Anzeigen',
        ],
        'create' => [
            'label' => 'Erstellen',
        ],
        'file' => [
            'label' => 'Datei',
        ],
        'distance_calc' => [
            'label' => 'distance_calc',
        ],
        'contacts' => [
            'label' => 'contacts',
            'description' => 'contacts',
            'helper_text' => 'contacts',
            'placeholder' => 'contacts',
        ],
        'layout' => [
            'label' => 'layout',
        ],
        'street_address' => [
            'description' => 'street_address',
            'helper_text' => 'street_address',
            'placeholder' => 'street_address',
            'label' => 'street_address',
        ],
        'created_at' => [
            'description' => 'created_at',
            'helper_text' => 'created_at',
            'placeholder' => 'created_at',
            'label' => 'created_at',
        ],
        'updated_at' => [
            'description' => 'updated_at',
            'helper_text' => 'updated_at',
            'placeholder' => 'updated_at',
            'label' => 'updated_at',
        ],
    ],
    'import' => [
        'label' => 'Kunden importieren',
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
            'label' => 'Aktualisierungsdatum',
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
    'messages' => [
        'coordinates_updated' => 'Koordinaten erfolgreich aktualisiert',
        'coordinates_update_failed' => 'Koordinatenaktualisierung fehlgeschlagen',
        'import_success' => 'Import erfolgreich abgeschlossen',
        'import_failed' => 'Import fehlgeschlagen',
    ],
    'model' => [
        'label' => 'Kunde',
        'plural' => 'Kunden',
    ],
    'sections' => [
        'contacts' => [
            'heading' => 'contacts',
            'label' => 'contacts',
        ],
        'address' => [
            'heading' => 'address',
            'label' => 'address',
        ],
    ],
];
