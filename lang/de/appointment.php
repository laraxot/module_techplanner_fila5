<?php

declare(strict_types=1);

return [
    // ==============================================
    // NAVIGATION & STRUCTURE
    // ==============================================
    'navigation' => [
        'label' => 'Termine',
        'plural_label' => 'Termine',
        'group' => 'TechPlanner',
        'icon' => 'heroicon-o-calendar-days',
        'sort' => 10,
        'badge' => 'Terminverwaltung',
    ],
    // ==============================================
    // MODEL INFORMATION
    // ==============================================
    'model' => [
        'label' => 'Termin',
        'plural' => 'Termine',
        'description' => 'Termin- und Buchungsverwaltung',
    ],
    // ==============================================
    // FIELDS - STRUTTURA ESPANSA OBBLIGATORIA
    // ==============================================
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => 'Eindeutige Termin-ID',
            'helper_text' => 'Eindeutige numerische Kennung des Termins im System',
        ],
        'client_id' => [
            'label' => 'Kunde',
            'placeholder' => 'Kunde auswählen',
            'tooltip' => 'Kunde, für den der Termin geplant ist',
            'helper_text' => 'Spezifischer Kunde, für den der Termin geplant wurde',
            'help' => 'Wählen Sie den Kunden aus der verfügbaren Liste',
        ],
        'date' => [
            'label' => 'Datum',
            'placeholder' => 'Datum auswählen',
            'tooltip' => 'Termindatum',
            'helper_text' => 'Spezifisches Datum, an dem der Termin stattfinden wird',
            'help' => 'Wählen Sie das passende Datum für den Termin',
        ],
        'time' => [
            'label' => 'Uhrzeit',
            'placeholder' => 'Uhrzeit auswählen',
            'tooltip' => 'Terminuhrzeit',
            'helper_text' => 'Spezifische Uhrzeit, zu der der Termin beginnt',
            'help' => 'Wählen Sie die passendste Uhrzeit',
        ],
        'status' => [
            'label' => 'Status',
            'placeholder' => 'Status auswählen',
            'tooltip' => 'Aktueller Terminstatus',
            'helper_text' => 'Aktueller Status des Termins im System',
            'help' => 'Wählen Sie den passenden Status aus der Liste',
            'options' => [
                'scheduled' => 'Geplant',
                'confirmed' => 'Bestätigt',
                'completed' => 'Abgeschlossen',
                'cancelled' => 'Storniert',
            ],
        ],
        'notes' => [
            'label' => 'Notizen',
            'placeholder' => 'Zusätzliche Notizen eingeben',
            'tooltip' => 'Notizen und Beobachtungen zum Termin',
            'helper_text' => 'Zusätzliche Informationen oder besondere Notizen zum Termin',
            'help' => 'Fügen Sie relevante Informationen hinzu',
        ],
        'machines_count' => [
            'label' => 'Anzahl Maschinen',
            'tooltip' => 'Anzahl beteiligter Maschinen',
            'helper_text' => 'Anzahl der Maschinen oder Geräte, die am Termin beteiligt sind',
        ],
        'created_at' => [
            'label' => 'Erstellungsdatum',
            'tooltip' => 'Termin-Erstellungsdatum',
            'helper_text' => 'Datum und Uhrzeit der Terminerstellung im System',
        ],
        'updated_at' => [
            'label' => 'Letzte Änderung',
            'tooltip' => 'Datum der letzten Änderung',
            'helper_text' => 'Datum und Uhrzeit der letzten Terminaktualisierung',
        ],
    ],
    // ==============================================
    // ACTIONS - STRUTTURA ESPANSA OBBLIGATORIA
    // ==============================================
    'actions' => [
        'create' => [
            'label' => 'Neuer Termin',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
            'tooltip' => 'Neuen Termin erstellen',
            'modal' => [
                'heading' => 'Neuen Termin erstellen',
                'description' => 'Details für den neuen Termin eingeben',
                'confirm' => 'Termin erstellen',
                'cancel' => 'Abbrechen',
            ],
            'messages' => [
                'success' => 'Termin erfolgreich erstellt',
                'error' => 'Fehler beim Erstellen des Termins',
            ],
        ],
        'edit' => [
            'label' => 'Termin bearbeiten',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning',
            'tooltip' => 'Ausgewählten Termin bearbeiten',
            'modal' => [
                'heading' => 'Termin bearbeiten',
                'description' => 'Termindetails aktualisieren',
                'confirm' => 'Änderungen speichern',
                'cancel' => 'Abbrechen',
            ],
            'messages' => [
                'success' => 'Termin erfolgreich aktualisiert',
                'error' => 'Fehler beim Aktualisieren des Termins',
            ],
        ],
        'delete' => [
            'label' => 'Termin löschen',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'tooltip' => 'Ausgewählten Termin löschen',
            'modal' => [
                'heading' => 'Termin löschen',
                'description' => 'Sind Sie sicher, dass Sie diesen Termin löschen möchten? Diese Aktion ist nicht rückgängig zu machen.',
                'confirm' => 'Löschen',
                'cancel' => 'Abbrechen',
            ],
            'messages' => [
                'success' => 'Termin erfolgreich gelöscht',
                'error' => 'Fehler beim Löschen des Termins',
            ],
            'confirmation' => 'Sind Sie sicher, dass Sie diesen Termin löschen möchten?',
        ],
        'view' => [
            'label' => 'Termin anzeigen',
            'icon' => 'heroicon-o-eye',
            'color' => 'secondary',
            'tooltip' => 'Termindetails anzeigen',
        ],
        'confirm' => [
            'label' => 'Termin bestätigen',
            'icon' => 'heroicon-o-check-circle',
            'color' => 'success',
            'tooltip' => 'Ausgewählten Termin bestätigen',
            'modal' => [
                'heading' => 'Termin bestätigen',
                'description' => 'Sind Sie sicher, dass Sie diesen Termin bestätigen möchten?',
                'confirm' => 'Bestätigen',
                'cancel' => 'Abbrechen',
            ],
            'messages' => [
                'success' => 'Termin erfolgreich bestätigt',
                'error' => 'Fehler beim Bestätigen des Termins',
            ],
        ],
        'cancel' => [
            'label' => 'Termin stornieren',
            'icon' => 'heroicon-o-x-circle',
            'color' => 'danger',
            'tooltip' => 'Ausgewählten Termin stornieren',
            'modal' => [
                'heading' => 'Termin stornieren',
                'description' => 'Sind Sie sicher, dass Sie diesen Termin stornieren möchten?',
                'confirm' => 'Stornieren',
                'cancel' => 'Schließen',
            ],
            'messages' => [
                'success' => 'Termin erfolgreich storniert',
                'error' => 'Fehler beim Stornieren des Termins',
            ],
        ],
        'bulk_actions' => [
            'delete' => [
                'label' => 'Ausgewählte löschen',
                'icon' => 'heroicon-o-trash',
                'color' => 'danger',
                'tooltip' => 'Ausgewählte Termine löschen',
                'modal' => [
                    'heading' => 'Ausgewählte Termine löschen',
                    'description' => 'Sind Sie sicher, dass Sie die ausgewählten Termine löschen möchten? Diese Aktion ist nicht rückgängig zu machen.',
                    'confirm' => 'Alle löschen',
                    'cancel' => 'Abbrechen',
                ],
                'messages' => [
                    'success' => 'Termine erfolgreich gelöscht',
                    'error' => 'Fehler beim Löschen der Termine',
                ],
            ],
            'confirm' => [
                'label' => 'Ausgewählte bestätigen',
                'icon' => 'heroicon-o-check-circle',
                'color' => 'success',
                'tooltip' => 'Ausgewählte Termine bestätigen',
                'modal' => [
                    'heading' => 'Ausgewählte Termine bestätigen',
                    'description' => 'Sind Sie sicher, dass Sie die ausgewählten Termine bestätigen möchten?',
                    'confirm' => 'Alle bestätigen',
                    'cancel' => 'Abbrechen',
                ],
                'messages' => [
                    'success' => 'Termine erfolgreich bestätigt',
                    'error' => 'Fehler beim Bestätigen der Termine',
                ],
            ],
        ],
    ],
    // ==============================================
    // SECTIONS - ORGANIZZAZIONE FORM
    // ==============================================
    'sections' => [
        'basic_info' => [
            'label' => 'Grundinformationen',
            'description' => 'Grundlegende Termininformationen',
            'icon' => 'heroicon-o-information-circle',
        ],
        'schedule' => [
            'label' => 'Zeitplanung',
            'description' => 'Datum, Uhrzeit und zeitliche Details',
            'icon' => 'heroicon-o-clock',
        ],
        'client_info' => [
            'label' => 'Kundeninformationen',
            'description' => 'Kundendetails und Notizen',
            'icon' => 'heroicon-o-user',
        ],
    ],
    // ==============================================
    // FILTERS - RICERCA E FILTRI
    // ==============================================
    'filters' => [
        'status' => [
            'label' => 'Status',
            'options' => [
                'scheduled' => 'Geplant',
                'confirmed' => 'Bestätigt',
                'completed' => 'Abgeschlossen',
                'cancelled' => 'Storniert',
            ],
        ],
        'client' => [
            'label' => 'Kunde',
            'placeholder' => 'Kunde auswählen',
        ],
        'date_range' => [
            'label' => 'Zeitraum',
            'placeholder' => 'Zeitraum auswählen',
        ],
        'search' => [
            'label' => 'Suche',
            'placeholder' => 'Termine suchen...',
        ],
    ],
    // ==============================================
    // MESSAGES - FEEDBACK UTENTE
    // ==============================================
    'messages' => [
        'empty_state' => 'Keine Termine gefunden',
        'search_placeholder' => 'Termine suchen...',
        'loading' => 'Termine werden geladen...',
        'total_count' => 'Gesamttermine: :count',
        'created' => 'Termin erfolgreich erstellt',
        'updated' => 'Termin erfolgreich aktualisiert',
        'deleted' => 'Termin erfolgreich gelöscht',
        'confirmed' => 'Termin erfolgreich bestätigt',
        'cancelled' => 'Termin erfolgreich storniert',
        'bulk_deleted' => 'Termine erfolgreich gelöscht',
        'bulk_confirmed' => 'Termine erfolgreich bestätigt',
        'error_general' => 'Ein Fehler ist aufgetreten. Bitte versuchen Sie es später erneut.',
        'error_validation' => 'Validierungsfehler sind aufgetreten.',
        'error_permission' => 'Sie haben keine Berechtigung, diese Aktion auszuführen.',
        'success_operation' => 'Vorgang erfolgreich abgeschlossen',
    ],
    // ==============================================
    // VALIDATION - MESSAGGI DI VALIDAZIONE
    // ==============================================
    'validation' => [
        'client_id_required' => 'Kunde ist erforderlich',
        'date_required' => 'Datum ist erforderlich',
        'time_required' => 'Uhrzeit ist erforderlich',
        'status_required' => 'Status ist erforderlich',
        'date_after' => 'Datum muss in der Zukunft liegen',
        'time_format' => 'Uhrzeit muss im HH:MM-Format sein',
        'notes_max' => 'Notizen dürfen :max Zeichen nicht überschreiten',
    ],
    // ==============================================
    // DESCRIPTIONS - DESCRIZIONI CONTESTUALI
    // ==============================================
    'descriptions' => [
        'appointment_purpose' => 'Vollständige Termin- und Buchungsverwaltung',
        'status_workflow' => 'Statusablauf: Geplant → Bestätigt → Abgeschlossen/Storniert',
        'best_practices' => 'Verfügbarkeit immer vor Bestätigung prüfen',
        'limitations' => 'Bereits abgeschlossene Termine können nicht geändert werden',
    ],
    // ==============================================
    // OPTIONS - OPZIONI E VALORI PREDEFINITI
    // ==============================================
    'options' => [
        'statuses' => [
            'scheduled' => 'Geplant',
            'confirmed' => 'Bestätigt',
            'completed' => 'Abgeschlossen',
            'cancelled' => 'Storniert',
        ],
        'time_slots' => [
            '09:00' => '09:00',
            '09:30' => '09:30',
            '10:00' => '10:00',
            '10:30' => '10:30',
            '11:00' => '11:00',
            '11:30' => '11:30',
            '14:00' => '14:00',
            '14:30' => '14:30',
            '15:00' => '15:00',
            '15:30' => '15:30',
            '16:00' => '16:00',
            '16:30' => '16:30',
        ],
        'priorities' => [
            'low' => 'Niedrig',
            'medium' => 'Mittel',
            'high' => 'Hoch',
            'urgent' => 'Dringend',
        ],
    ],
];
