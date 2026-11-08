<?php

declare(strict_types=1);

return [
    'sections' => [
        'title' => [
            'title' => 'Referenzposition',
        ],
    ],
    'actions' => [
        'update_button' => [
            'label' => 'Position aktualisieren',
        ],
    ],
    'fields' => ['latitude' => 'Breitengrad', 'longitude' => 'Längengrad'],
    'notifications' => [
        'invalid' => ['title' => 'Ungültige Koordinaten', 'body' => 'Der Breitengrad muss zwischen -90 und 90 und der Längengrad zwischen -180 und 180 liegen.'],
        'updated' => ['title' => 'Koordinaten aktualisiert', 'body' => 'Die Tabelle wurde nach Entfernung von den ausgewählten Koordinaten sortiert.'],
    ],
];
