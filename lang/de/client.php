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
        'geocodeCoordinates' => [
            'label' => 'Aus Adresse aktualisieren',
            'failed_title' => 'Geocodierung fehlgeschlagen',
            'success_title' => 'Koordinaten aus Adresse aktualisiert',
        ],
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
            'modal' => ['heading' => 'Koordinaten aktualisieren', 'description' => 'Koordinaten aller Kunden anhand ihrer Adressen aktualisieren?', 'submit_label' => 'Ja, alle aktualisieren'],
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
        'last_rx_control_date' => [
            'label' => 'Letzte Röntgenkontrolle',
        ],
        'last_intraoral_control_date' => [
            'label' => 'Letzte intraorale Kontrolle',
        ],
        'last_electromedical_control_date' => [
            'label' => 'Letzte elektromedizinische Kontrolle',
        ],
        'last_health_authorization_date' => [
            'label' => 'Letzte Gesundheitszulassung',
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
    'filters' => [
        'has_controls' => ['label' => 'Hat erfasste Kontrollen'],
        'controls_expiring' => ['label' => 'Kontrollen laufen ab (30 Tage)'],
        'never_controlled_type' => ['label' => 'Nach Typ nie kontrolliert'],
        'has_rx_control' => ['label' => 'Röntgenkontrolle'],
        'has_electromedical_control' => ['label' => 'Elektromedizinische Kontrolle'],
        'has_health_authorization' => ['label' => 'Gesundheitszulassung'],
    ],
    'map' => [
        'markers_shown' => ':count Kunden-Marker mit Koordinaten werden angezeigt',
        'aria_label' => 'Kundenkarte',
        'set_origin' => 'Als Ursprung verwenden',
        'set_origin_tooltip' => 'Alle Kunden nach Entfernung von diesem Punkt sortieren',
        'origin_popup' => 'Referenzpunkt für die Entfernung',
        'origin_set' => ['title' => 'Ausgangspunkt gesetzt', 'body' => 'Die Tabelle wurde nach Entfernung zu diesem Kunden sortiert.'],
        'origin_missing' => ['title' => 'Koordinaten fehlen', 'body' => 'Der ausgewählte Kunde hat keine verwendbaren Koordinaten.'],
        'origin_missing_geocode_failed' => [
            'title' => 'Geocodierung fehlgeschlagen',
            'body' => 'Die Adresse des Kunden konnte nicht geocodiert werden. Prüfen Sie die Adresse oder verwenden Sie "Koordinaten aktualisieren", um alle fehlenden Koordinaten zu füllen.',
        ],
    ],
    'location_map' => [
        'heading' => 'Kundenstandort',
        'aria_label' => 'Kartenansicht des Kundenstandorts',
        'google_maps' => 'In Google Maps öffnen',
        'viamichelin' => 'In ViaMichelin öffnen',
        'missing' => 'Koordinaten sind nicht verfügbar. Adresse vervollständigen und „Aus Adresse aktualisieren“ im Abschnitt Koordinaten verwenden.',
    ],
    'messages' => [
        'coordinates_batch_summary' => ':processed Kunden verarbeitet. Koordinaten für :success aktualisiert.',
        'coordinates_batch_warning' => 'Koordinatenaktualisierung mit Fehlern abgeschlossen',
        'coordinates_batch_success' => 'Koordinaten erfolgreich aktualisiert',
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
        'coordinates' => [
            'label' => 'Koordinaten',
            'description' => 'Breiten- und Längengrad des Kunden. Adresse zuerst speichern, dann hier die Koordinaten für Entfernung und Karte aktualisieren.',
        ],
        'contacts' => [
            'heading' => 'Kontakte',
            'label' => 'Kontakte',
        ],
        'address_info' => [
            'label' => 'Adresse',
        ],
        'address' => [
            'heading' => 'address',
            'label' => 'address',
        ],
    ],
];
