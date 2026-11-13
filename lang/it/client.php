<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => 'Lavoro quotidiano',
        'label' => 'Clienti',
        'plural_label' => 'Clienti',
        'icon' => 'techplanner-client',
        'sort' => 10,
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo Cliente',
            'tooltip' => '',
            'icon' => 'create',
        ],
        'import' => [
            'label' => 'Importa Clienti',
        ],
        'importClient' => [
            'label' => 'Importa clienti',
            'tooltip' => '',
            'icon' => 'importClient',
        ],
        'populateCoordinates' => [
            'label' => 'Aggiorna coordinate',
            'tooltip' => '',
            'icon' => 'populateCoordinates',
            'modal' => [
                'heading' => 'Aggiorna Coordinate',
                'description' => 'Questa azione aggiornerà le coordinate per tutti i clienti basandosi sui loro indirizzi. Vuoi continuare?',
                'submit_label' => 'Sì, Aggiorna Tutto',
            ],
        ],
        'updateCoordinates' => [
            'label' => 'Aggiorna Coordinate',
            'tooltip' => '',
            'icon' => 'updateCoordinates',
        ],
        'sortByDistance' => [
            'label' => 'Ordina per distanza',
            'tooltip' => 'Mette in cima i clienti più vicini a questo',
            'icon' => 'heroicon-o-map',
            'no_coordinates' => [
                'title' => 'Mancano le coordinate',
                'body' => 'Questo cliente non ha coordinate: usa prima «Aggiorna coordinate».',
            ],
            'done' => [
                'title' => 'Elenco ordinato per distanza',
                'body' => 'In cima trovi i clienti più vicini a :name.',
            ],
        ],
        'downloadExample' => [
            'label' => 'Scarica Esempio',
            'tooltip' => '',
            'icon' => 'downloadExample',
        ],
        'logout' => [
            'tooltip' => '',
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'profile' => [
            'tooltip' => '',
            'icon' => 'profile',
            'label' => 'profile',
        ],
        'cancel' => [
            'tooltip' => '',
            'icon' => 'cancel',
            'label' => 'cancel',
        ],
        'save' => [
            'tooltip' => '',
            'icon' => 'save',
            'label' => 'save',
        ],
        'reorderRecords' => [
            'tooltip' => '',
            'icon' => 'reorderRecords',
            'label' => 'reorderRecords',
        ],
        'openColumnManager' => [
            'tooltip' => '',
            'icon' => 'openColumnManager',
            'label' => 'openColumnManager',
        ],
        'applyTableColumnManager' => [
            'tooltip' => '',
            'icon' => 'applyTableColumnManager',
            'label' => 'applyTableColumnManager',
        ],
        'resetFilters' => [
            'tooltip' => '',
            'icon' => 'resetFilters',
            'label' => 'resetFilters',
        ],
        'applyFilters' => [
            'tooltip' => '',
            'icon' => 'applyFilters',
            'label' => 'applyFilters',
        ],
        'openFilters' => [
            'tooltip' => '',
            'icon' => 'openFilters',
            'label' => 'openFilters',
        ],
        'delete' => [
            'tooltip' => '',
            'icon' => 'delete',
            'label' => 'delete',
        ],
        'edit' => [
            'tooltip' => '',
            'icon' => 'edit',
            'label' => 'edit',
        ],
        'view' => [
            'tooltip' => '',
            'icon' => 'view',
            'label' => 'view',
        ],
        'layout' => [
            'tooltip' => '',
            'icon' => 'layout',
            'label' => 'layout',
        ],
        'SendNotificationBulkAction' => [
            'tooltip' => '',
            'label' => 'SendNotificationBulkAction',
            'icon' => 'SendNotificationBulkAction',
        ],
        'UpdateCoordinatesBulkAction' => [
            'tooltip' => '',
            'icon' => 'UpdateCoordinatesBulkAction',
            'label' => 'UpdateCoordinatesBulkAction',
        ],
        'send_notification_bulk' => [
            'tooltip' => '',
            'icon' => 'send_notification_bulk',
            'label' => 'Invia notifica',
        ],
        'update_coordinates_bulk' => [
            'tooltip' => '',
            'icon' => 'update_coordinates_bulk',
            'label' => 'Aggiorna coordinate',
        ],
        'SendRecordsNotificationBulkAction' => [
            'tooltip' => '',
            'icon' => 'SendRecordsNotificationBulkAction',
            'label' => 'SendRecordsNotificationBulkAction',
        ],
        'sendRecordsNotification' => [
            'tooltip' => '',
            'icon' => 'sendRecordsNotification',
            'label' => 'Invia notifica',
        ],
        'removeAllFilters' => [
            'tooltip' => '',
            'icon' => 'removeAllFilters',
            'label' => 'removeAllFilters',
        ],
        'resetColumnManager' => [
            'tooltip' => '',
            'icon' => 'resetColumnManager',
            'label' => 'resetColumnManager',
        ],
        'createAnother' => [
            'label' => 'createAnother',
            'icon' => 'createAnother',
            'tooltip' => '',
        ],
        'submit' => [
<<<<<<< .merge_file_IcvpGk
            'tooltip' => 'submit',
            'icon' => 'submit',
=======
            'label' => 'submit',
            'icon' => 'submit',
            'tooltip' => '',
        ],
        'geocodeCoordinates' => [
            'label' => 'Aggiorna da indirizzo',
            'failed_title' => 'Geocoding non riuscito',
            'success_title' => 'Coordinate aggiornate dall\'indirizzo',
>>>>>>> .merge_file_rSUHnZ
        ],
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'business_closed' => [
            'label' => 'Attività Cessata',
            'description' => 'business_closed',
            'helper_text' => '',
            'placeholder' => '',
        ],
        'company_name' => [
            'label' => 'Ragione Sociale',
            'description' => 'company_name',
            'helper_text' => '',
            'placeholder' => '',
        ],
        'latitude' => [
            'label' => 'Latitudine',
            'description' => 'latitude',
            'helper_text' => '',
            'placeholder' => '',
        ],
        'longitude' => [
            'label' => 'Longitudine',
            'description' => 'longitude',
            'helper_text' => '',
            'placeholder' => '',
        ],
        'distance' => [
            'label' => 'Distanza',
        ],
        'distance_km' => [
<<<<<<< .merge_file_IcvpGk
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
=======
            'label' => 'Km',
>>>>>>> .merge_file_rSUHnZ
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
            'helper_text' => '',
            'placeholder' => '',
        ],
        'tax_code' => [
            'label' => 'Codice Fiscale',
            'description' => 'tax_code',
            'helper_text' => '',
            'placeholder' => '',
        ],
        'vat_number' => [
            'label' => 'Partita IVA',
            'description' => 'vat_number',
            'helper_text' => '',
            'placeholder' => '',
        ],
        'fiscal_code' => [
            'label' => 'Codice Fiscale',
            'description' => 'fiscal_code',
            'helper_text' => '',
            'placeholder' => '',
        ],
        'competent_health_unit' => [
            'label' => 'ASL Competente',
            'description' => 'competent_health_unit',
            'helper_text' => '',
            'placeholder' => '',
        ],
        'address' => [
            'label' => 'Indirizzo',
            'description' => 'address',
            'helper_text' => '',
            'placeholder' => '',
        ],
        'street_number' => [
            'label' => 'Numero Civico',
            'description' => 'street_number',
            'helper_text' => '',
            'placeholder' => '',
        ],
        'postal_code' => [
            'label' => 'CAP',
            'description' => 'postal_code',
            'helper_text' => '',
            'placeholder' => '',
        ],
        'province' => [
            'label' => 'Provincia',
            'description' => 'province',
            'helper_text' => '',
            'placeholder' => '',
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
            'helper_text' => '',
            'placeholder' => '',
        ],
        'activity' => [
            'label' => 'Attività',
            'description' => 'activity',
            'helper_text' => '',
            'placeholder' => '',
        ],
        'name' => [
            'label' => 'Nome',
        ],
        'city' => [
            'label' => 'Città',
            'description' => 'city',
            'helper_text' => '',
            'placeholder' => '',
        ],
        'company_office' => [
            'label' => 'Sede Legale',
            'description' => 'company_office',
            'helper_text' => '',
            'placeholder' => '',
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
            'helper_text' => '',
            'placeholder' => '',
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
            'helper_text' => '',
            'placeholder' => '',
        ],
        'view' => [
            'label' => 'Visualizza',
        ],
        'create' => [
            'label' => 'Crea',
        ],
        'file' => [
            'label' => 'File',
            'placeholder' => '',
            'helper_text' => '',
            'description' => 'file',
        ],
        'distance_calc' => [
            'label' => 'Distanza',
        ],
        'contacts' => [
            'label' => 'Contatti',
            'description' => 'contacts',
            'helper_text' => '',
            'placeholder' => '',
        ],
        'layout' => [
            'label' => 'layout',
        ],
        'street_address' => [
            'description' => 'street_address',
            'helper_text' => '',
            'placeholder' => '',
            'label' => 'Indirizzo',
        ],
        'created_at' => [
            'description' => 'created_at',
            'helper_text' => '',
            'placeholder' => '',
            'label' => 'Creato il',
        ],
        'updated_at' => [
            'description' => 'updated_at',
            'helper_text' => '',
            'placeholder' => '',
            'label' => 'Modificato il',
        ],
        'contact' => [
            'label' => 'Contatto',
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
        'last_health_authorization_date' => [
            'label' => 'Ultima autorizzazione sanitaria',
        ],
        'isActive' => [
            'description' => 'isActive',
            'helper_text' => '',
            'placeholder' => '',
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
    'messages' => [
        'coordinates_updated' => 'Coordinate aggiornate con successo',
        'coordinates_update_failed' => 'Aggiornamento coordinate fallito',
        'import_success' => 'Importazione completata con successo',
        'import_failed' => 'Importazione fallita',
        'coordinates_batch_summary' => 'Elaborati :processed clienti. Coordinate aggiornate per :success.',
        'coordinates_batch_warning' => 'Aggiornamento coordinate completato con errori',
        'coordinates_batch_success' => 'Coordinate aggiornate con successo',
    ],
    'model' => [
        'label' => 'Cliente',
        'plural' => 'Clienti',
    ],
    'sections' => [
        'contacts' => [
            'heading' => 'contacts',
            'label' => 'Contatti',
        ],
        'address' => [
            'heading' => 'address',
            'label' => 'Indirizzo',
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
        'coordinates' => [
            'label' => 'Coordinate',
            'description' => 'Latitudine e longitudine del cliente. Salva prima l’indirizzo, poi aggiorna qui le coordinate per distanza e mappa.',
        ],
        'address_info' => [
            'label' => 'Indirizzo',
        ],
    ],
    'label' => 'Cliente',
    'plural_label' => 'Clienti',
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
<<<<<<< .merge_file_IcvpGk
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
=======
    'map' => [
        'markers_shown' => 'Mostrati :count marker di clienti con coordinate',
        'aria_label' => 'Mappa dei clienti',
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
>>>>>>> .merge_file_rSUHnZ
];
