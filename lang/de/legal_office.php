<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Anwaltskanzlei',
        'group' => 'TechPlanner',
        'icon' => 'heroicon-o-building-office',
        'sort' => 9,
    ],
    'resource' => [
        'label' => 'Anwaltskanzlei',
        'plural_label' => 'Anwaltskanzleien',
        'navigation_group' => 'TechPlanner',
        'navigation_icon' => 'heroicon-o-building-office',
        'navigation_sort' => 9,
        'description' => 'Anwaltskanzlei-Verwaltung',
    ],
    'actions' => [
        'create' => [
            'label' => 'Neue Anwaltskanzlei',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
            'tooltip' => 'Neue Anwaltskanzlei erstellen',
        ],
        'edit' => [
            'label' => 'Bearbeiten',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning',
            'tooltip' => 'Anwaltskanzlei bearbeiten',
        ],
        'delete' => [
            'label' => 'Löschen',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'tooltip' => 'Anwaltskanzlei löschen',
        ],
        'view' => [
            'label' => 'Anzeigen',
            'icon' => 'heroicon-o-eye',
            'color' => 'info',
            'tooltip' => 'Anwaltskanzlei anzeigen',
        ],
    ],
    'fields' => [
        'name' => [
            'label' => 'Kanzleienname',
            'placeholder' => 'Anwaltskanzlei-Namen eingeben',
            'help' => 'Vollständiger Name der Anwaltskanzlei',
        ],
        'address' => [
            'label' => 'Adresse',
            'placeholder' => 'Vollständige Adresse eingeben',
            'help' => 'Vollständige Adresse der Anwaltskanzlei',
        ],
        'phone' => [
            'label' => 'Telefon',
            'placeholder' => 'Telefonnummer eingeben',
            'help' => 'Haupttelefonnummer',
        ],
        'email' => [
            'label' => 'E-Mail',
            'placeholder' => 'E-Mail-Adresse eingeben',
            'help' => 'Haupt-E-Mail-Adresse der Kanzlei',
        ],
        'website' => [
            'label' => 'Website',
            'placeholder' => 'Website-URL eingeben',
            'help' => 'Website-URL der Kanzlei',
        ],
        'vat_number' => [
            'label' => 'USt-IdNr.',
            'placeholder' => 'USt-IdNr. eingeben',
            'help' => 'USt-IdNr. der Anwaltskanzlei',
        ],
        'fiscal_code' => [
            'label' => 'Steuerliche Identifikationsnummer',
            'placeholder' => 'Steuerliche Identifikationsnummer eingeben',
            'help' => 'Steuerliche Identifikationsnummer der Anwaltskanzlei',
        ],
        'is_active' => [
            'label' => 'Aktiv',
            'help' => 'Ob die Anwaltskanzlei aktiv ist',
        ],
    ],
    'filters' => [
        'is_active' => [
            'label' => 'Status',
            'options' => [
                'active' => 'Aktiv',
                'inactive' => 'Inaktiv',
            ],
        ],
        'city' => [
            'label' => 'Stadt',
            'placeholder' => 'Stadt auswählen',
        ],
    ],
    'messages' => [
        'created' => 'Anwaltskanzlei erfolgreich erstellt',
        'updated' => 'Anwaltskanzlei erfolgreich aktualisiert',
        'deleted' => 'Anwaltskanzlei erfolgreich gelöscht',
        'not_found' => 'Anwaltskanzlei nicht gefunden',
        'validation_error' => 'Validierungsfehler in den eingegebenen Daten',
    ],
];
