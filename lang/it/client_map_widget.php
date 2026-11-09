<?php

declare(strict_types=1);

return [
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
        'view' => 'Visualizza',
        'view_tooltip' => 'Visualizza la scheda del cliente',
        'edit' => 'Modifica',
        'edit_tooltip' => 'Modifica il cliente',
];
