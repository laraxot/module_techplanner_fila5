<?php

declare(strict_types=1);

return [
    'sections' => [
        'title' => [
            'title' => 'Reference Position',
        ],
    ],
    'actions' => [
        'update_button' => [
            'label' => 'Update Position',
        ],
    ],
    'fields' => ['latitude' => 'Latitude', 'longitude' => 'Longitude'],
    'notifications' => [
        'invalid' => ['title' => 'Invalid coordinates', 'body' => 'Latitude must be between -90 and 90; longitude between -180 and 180.'],
        'updated' => ['title' => 'Coordinates updated', 'body' => 'The table was sorted by distance from the selected coordinates.'],
    ],
];
