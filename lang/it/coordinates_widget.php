<?php

declare(strict_types=1);

return [
    'sections' => [
        'title' => [
            'title' => 'Posizione di Riferimento',
        ],
    ],
    'actions' => [
        'update_button' => [
            'label' => 'Aggiorna Posizione',
        ],
    ],
    'fields' => ['latitude' => 'Latitudine', 'longitude' => 'Longitudine'],
    'notifications' => [
        'invalid' => ['title' => 'Coordinate non valide', 'body' => 'Latitudine tra -90 e 90, longitudine tra -180 e 180.'],
        'updated' => ['title' => 'Coordinate aggiornate', 'body' => 'La tabella è stata ordinata in base alla distanza dalle coordinate impostate.'],
    ],
];
