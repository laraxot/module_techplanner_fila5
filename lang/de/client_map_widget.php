<?php

declare(strict_types=1);

return [
        'markers_shown' => ':count Kunden-Marker mit Koordinaten werden angezeigt',
        'aria_label' => 'Kundenkarte',
        'fullscreen' => 'Vollbild',
        'fullscreen_exit' => 'Vollbild beenden',
        'locate' => 'Auf meinen Standort zentrieren',
        'layer_satellite' => 'Satellit',
        'set_origin' => 'Als Ursprung verwenden',
        'set_origin_tooltip' => 'Alle Kunden nach Entfernung von diesem Punkt sortieren',
        'origin_popup' => 'Referenzpunkt für die Entfernung',
        'origin_set' => ['title' => 'Ausgangspunkt gesetzt', 'body' => 'Die Tabelle wurde nach Entfernung zu diesem Kunden sortiert.'],
        'origin_missing' => ['title' => 'Koordinaten fehlen', 'body' => 'Der ausgewählte Kunde hat keine verwendbaren Koordinaten.'],
        'origin_missing_geocode_failed' => [
            'title' => 'Geocodierung fehlgeschlagen',
            'body' => 'Die Adresse des Kunden konnte nicht geocodiert werden. Prüfen Sie die Adresse oder verwenden Sie "Koordinaten aktualisieren", um alle fehlenden Koordinaten zu füllen.',
        ],
        'view' => 'Ansehen',
        'view_tooltip' => 'Kundenprofil ansehen',
        'edit' => 'Bearbeiten',
        'edit_tooltip' => 'Kunden bearbeiten',
];
