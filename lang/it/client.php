<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => 'techplanner',
        'label' => 'Clienti',
        'icon' => 'techplanner-client',
        'sort' => 30,
    ],
    'actions' => [
        'geocodeCoordinates' => [
            'label' => 'Aggiorna da indirizzo',
            'failed_title' => 'Geocoding non riuscito',
            'success_title' => 'Coordinate aggiornate dall\'indirizzo',
        ],
        'create' => [
            'label' => 'Nuovo Cliente',
            'tooltip' => 'create',
            'icon' => 'create',
        ],
        'import' => [
            'label' => 'Importa Clienti',
        ],
        'importClient' => [
            'label' => 'Importa Clienti',
            'tooltip' => 'importClient',
            'icon' => 'importClient',
        ],
        'populateCoordinates' => [
            'label' => 'Aggiorna Coordinate',
            'tooltip' => 'populateCoordinates',
            'icon' => 'populateCoordinates',
            'modal' => [
                'heading' => 'Aggiorna Coordinate',
                'description' => 'Questa azione aggiornerà le coordinate per tutti i clienti basandosi sui loro indirizzi. Vuoi continuare?',
                'submit_label' => 'Sì, Aggiorna Tutto',
            ],
        ],
        'updateCoordinates' => [
            'label' => 'Aggiorna Coordinate',
            'tooltip' => 'updateCoordinates',
            'icon' => 'updateCoordinates',
        ],
        'sortByDistance' => [
            'label' => 'Ordina per Distanza',
            'tooltip' => 'sortByDistance',
            'icon' => 'sortByDistance',
        ],
        'downloadExample' => [
            'label' => 'Scarica Esempio',
            'tooltip' => 'downloadExample',
            'icon' => 'downloadExample',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'profile' => [
            'tooltip' => 'profile',
            'icon' => 'profile',
            'label' => 'profile',
        ],
        'cancel' => [
            'tooltip' => 'cancel',
            'icon' => 'cancel',
            'label' => 'cancel',
        ],
        'save' => [
            'tooltip' => 'save',
            'icon' => 'save',
            'label' => 'save',
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
        'applyTableColumnManager' => [
            'tooltip' => 'applyTableColumnManager',
            'icon' => 'applyTableColumnManager',
            'label' => 'applyTableColumnManager',
        ],
        'resetFilters' => [
            'tooltip' => 'resetFilters',
            'icon' => 'resetFilters',
            'label' => 'resetFilters',
        ],
        'applyFilters' => [
            'tooltip' => 'applyFilters',
            'icon' => 'applyFilters',
            'label' => 'applyFilters',
        ],
        'openFilters' => [
            'tooltip' => 'openFilters',
            'icon' => 'openFilters',
            'label' => 'openFilters',
        ],
        'delete' => [
            'tooltip' => 'delete',
            'icon' => 'delete',
            'label' => 'delete',
        ],
        'edit' => [
            'tooltip' => 'edit',
            'icon' => 'edit',
            'label' => 'edit',
        ],
        'view' => [
            'tooltip' => 'view',
            'icon' => 'view',
            'label' => 'view',
        ],
        'layout' => [
            'tooltip' => 'layout',
            'icon' => 'layout',
            'label' => 'layout',
        ],
        'SendNotificationBulkAction' => [
            'tooltip' => 'SendNotificationBulkAction',
            'label' => 'SendNotificationBulkAction',
            'icon' => 'SendNotificationBulkAction',
        ],
        'UpdateCoordinatesBulkAction' => [
            'tooltip' => 'UpdateCoordinatesBulkAction',
            'icon' => 'UpdateCoordinatesBulkAction',
            'label' => 'UpdateCoordinatesBulkAction',
        ],
        'send_notification_bulk' => [
            'tooltip' => 'send_notification_bulk',
            'icon' => 'send_notification_bulk',
            'label' => 'send_notification_bulk',
        ],
        'update_coordinates_bulk' => [
            'tooltip' => 'update_coordinates_bulk',
            'icon' => 'update_coordinates_bulk',
            'label' => 'update_coordinates_bulk',
        ],
        'SendRecordsNotificationBulkAction' => [
            'tooltip' => 'SendRecordsNotificationBulkAction',
            'icon' => 'SendRecordsNotificationBulkAction',
            'label' => 'SendRecordsNotificationBulkAction',
        ],
        'sendRecordsNotification' => [
            'tooltip' => 'sendRecordsNotification',
            'icon' => 'sendRecordsNotification',
            'label' => 'sendRecordsNotification',
        ],
        'removeAllFilters' => [
            'tooltip' => 'removeAllFilters',
            'icon' => 'removeAllFilters',
            'label' => 'removeAllFilters',
        ],
        'resetColumnManager' => [
            'tooltip' => 'resetColumnManager',
            'icon' => 'resetColumnManager',
            'label' => 'resetColumnManager',
        ],
        'submit' => [
            'tooltip' => 'submit',
        ],
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'business_closed' => [
            'label' => 'Attività Cessata',
            'description' => 'business_closed',
            'helper_text' => 'business_closed',
            'placeholder' => 'business_closed',
        ],
        'company_name' => [
            'label' => 'Ragione Sociale',
            'description' => 'company_name',
            'helper_text' => 'company_name',
            'placeholder' => 'company_name',
        ],
        'latitude' => [
            'label' => 'Latitudine',
            'description' => 'latitude',
            'helper_text' => 'latitude',
            'placeholder' => 'latitude',
        ],
        'longitude' => [
            'label' => 'Longitudine',
            'description' => 'longitude',
            'helper_text' => 'longitude',
            'placeholder' => 'longitude',
        ],
        'distance' => [
            'label' => 'Distanza',
        ],
        'distance_km' => [
            'label' => 'km',
        ],
        'last_rx_control_date' => [
            'label' => 'Ultimo controllo RX',
        ],
        'last_intraoral_control_date' => [
            'label' => 'Ultimo controllo endorale',
        ],
        'last_electromedical_control_date' => [
            'label' => 'Ultimo controllo elettromedicali',
        ],
        'last_appointment' => [
            'label' => 'Ultimo appuntamento',
        ],
        'last_health_authorization_date' => [
            'label' => 'Ultima autorizzazione sanitaria',
        ],
        'is_active' => [
            'label' => 'Attivo',
        ],
        'full_address' => [
            'label' => 'Indirizzo Completo',
        ],
        'country' => [
            'label' => 'Paese',
            'description' => 'country',
            'helper_text' => 'country',
            'placeholder' => 'country',
        ],
        'tax_code' => [
            'label' => 'Codice Fiscale',
            'description' => 'tax_code',
            'helper_text' => 'tax_code',
            'placeholder' => 'tax_code',
        ],
        'vat_number' => [
            'label' => 'Partita IVA',
            'description' => 'vat_number',
            'helper_text' => 'vat_number',
            'placeholder' => 'vat_number',
        ],
        'fiscal_code' => [
            'label' => 'Codice Fiscale',
            'description' => 'fiscal_code',
            'helper_text' => 'fiscal_code',
            'placeholder' => 'fiscal_code',
        ],
        'competent_health_unit' => [
            'label' => 'ASL Competente',
            'description' => 'competent_health_unit',
            'helper_text' => 'competent_health_unit',
            'placeholder' => 'competent_health_unit',
        ],
        'address' => [
            'label' => 'Indirizzo',
            'description' => 'address',
            'helper_text' => 'address',
            'placeholder' => 'address',
        ],
        'street_number' => [
            'label' => 'Numero Civico',
            'description' => 'street_number',
            'helper_text' => 'street_number',
            'placeholder' => 'street_number',
        ],
        'postal_code' => [
            'label' => 'CAP',
            'description' => 'postal_code',
            'helper_text' => 'postal_code',
            'placeholder' => 'postal_code',
        ],
        'province' => [
            'label' => 'Provincia',
            'description' => 'province',
            'helper_text' => 'province',
            'placeholder' => 'province',
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
        'notes' => [
            'label' => 'Note',
            'description' => 'notes',
            'helper_text' => 'notes',
            'placeholder' => 'notes',
        ],
        'activity' => [
            'label' => 'Attività',
            'description' => 'activity',
            'helper_text' => 'activity',
            'placeholder' => 'activity',
        ],
        'name' => [
            'label' => 'Nome',
        ],
        'city' => [
            'label' => 'Città',
            'description' => 'city',
            'helper_text' => 'city',
            'placeholder' => 'city',
        ],
        'company_office' => [
            'label' => 'Sede Legale',
            'description' => 'company_office',
            'helper_text' => 'company_office',
            'placeholder' => 'company_office',
        ],
        'sortByDistance' => [
            'label' => 'Ordina per Distanza',
        ],
        'toggleColumns' => [
            'label' => 'Attiva/Disattiva Colonne',
        ],
        'reorderRecords' => [
            'label' => 'Riorganizza Record',
        ],
        'resetFilters' => [
            'label' => 'Resetta Filtro',
        ],
        'applyFilters' => [
            'label' => 'Applica Filtro',
        ],
        'openFilters' => [
            'label' => 'Apri Filtri',
        ],
        'value' => [
            'label' => 'Valore',
            'description' => 'value',
            'helper_text' => 'value',
            'placeholder' => 'value',
        ],
        'delete' => [
            'label' => 'Elimina',
        ],
        'edit' => [
            'label' => 'Modifica',
        ],
        'values' => [
            'label' => 'Valori',
            'description' => 'values',
            'helper_text' => 'values',
            'placeholder' => 'values',
        ],
        'view' => [
            'label' => 'Visualizza',
        ],
        'create' => [
            'label' => 'Crea',
        ],
        'file' => [
            'label' => 'File',
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
        'contact' => [
            'label' => 'contact',
        ],
        'isActive' => [
            'description' => 'isActive',
            'helper_text' => 'isActive',
            'placeholder' => 'isActive',
            'label' => 'isActive',
        ],
    ],
    'import' => [
        'label' => 'Importa Clienti',
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
            'label' => 'Data Aggiornamento',
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
    'filters' => [
        'has_controls' => [
            'label' => 'Ha controlli registrati',
        ],
        'controls_expiring' => [
            'label' => 'Controlli in scadenza (30 gg)',
        ],
        'last_appointment_type' => [
            'label' => 'Ultimo appuntamento per tipo',
            'none' => 'Nessun appuntamento',
        ],
        'never_controlled_type' => [
            'label' => 'Mai controllato per tipo',
        ],
        'has_rx_control' => [
            'label' => 'Controllo RX',
        ],
        'has_electromedical_control' => [
            'label' => 'Controllo elettromedicali',
        ],
        'has_health_authorization' => [
            'label' => 'Autorizzazione sanitaria',
        ],
    ],
    'map' => [
        'markers_shown' => 'Mostrati :count marker di clienti con coordinate',
        'aria_label' => 'Mappa dei clienti',
        'fullscreen' => 'Schermo intero',
        'locate' => 'Centra sulla mia posizione',
        'layer_satellite' => 'Satellite',
        'set_origin' => 'Usa come origine',
        'set_origin_tooltip' => 'Ordina tutti i clienti per distanza da questo punto',
        'origin_popup' => 'Punto di riferimento per la distanza',
        'origin_set' => [
            'title' => 'Punto di partenza impostato',
            'body' => 'La tabella è stata ordinata per distanza da questo cliente.',
        ],
        'origin_missing' => [
            'title' => 'Coordinate mancanti',
            'body' => 'Il cliente selezionato non ha coordinate utilizzabili.',
        ],
        'origin_missing_geocode_failed' => [
            'title' => 'Geocodifica non riuscita',
            'body' => 'Impossibile geocodificare l\'indirizzo del cliente. Controlla l\'indirizzo o usa "Aggiorna Coordinate" per popolare tutte le coordinate mancanti.',
        ],
    ],
    'location_map' => [
        'heading' => 'Posizione cliente',
        'aria_label' => 'Mappa della posizione del cliente',
        'google_maps' => 'Apri in Google Maps',
        'viamichelin' => 'Apri in ViaMichelin',
        'missing' => 'Coordinate non disponibili. Completa l’indirizzo e usa “Aggiorna da indirizzo” nella sezione Coordinate.',
    ],
    'messages' => [
        'coordinates_batch_summary' => 'Elaborati :processed clienti. Coordinate aggiornate per :success.',
        'coordinates_batch_warning' => 'Aggiornamento coordinate completato con errori',
        'coordinates_batch_success' => 'Coordinate aggiornate con successo',
        'coordinates_updated' => 'Coordinate aggiornate con successo',
        'coordinates_update_failed' => 'Aggiornamento coordinate fallito',
        'import_success' => 'Importazione completata con successo',
        'import_failed' => 'Importazione fallita',
    ],
    'model' => [
        'label' => 'Cliente',
        'plural' => 'Clienti',
    ],
    'sections' => [
        'coordinates' => [
            'label' => 'Coordinate',
            'description' => 'Latitudine e longitudine del cliente. Salva prima l’indirizzo, poi aggiorna qui le coordinate per distanza e mappa.',
        ],
        'contacts' => [
            'heading' => 'Contatti',
            'label' => 'Contatti',
        ],
        'address_info' => [
            'label' => 'Indirizzo',
        ],
        'address' => [
            'heading' => 'address',
            'label' => 'address',
        ],
        'company' => [
            'heading' => 'company',
            'label' => 'Informazioni Azienda',
        ],
        'contact_info' => [
            'label' => 'Informazioni Contatto',
        ],
        'additional_info' => [
            'label' => 'Informazioni Aggiuntive',
        ],
        'tech_planner::client' => [
            'sections' => [
                'additional_info' => [
                    'label' => [
                        'heading' => 'tech_planner::client.sections.additional_info.label',
                    ],
                ],
            ],
        ],
    ],
    'label' => 'client',
];
