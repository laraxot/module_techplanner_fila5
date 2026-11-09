<?php

declare(strict_types=1);

return [
        'markers_shown' => 'Showing :count client markers with coordinates',
        'aria_label' => 'Client map',
        'fullscreen' => 'Fullscreen',
        'fullscreen_exit' => 'Exit fullscreen',
        'locate' => 'Center on my location',
        'layer_satellite' => 'Satellite',
        'set_origin' => 'Use as origin',
        'set_origin_tooltip' => 'Sort all clients by distance from this point',
        'origin_popup' => 'Distance reference point',
        'origin_set' => ['title' => 'Origin point set', 'body' => 'The table has been sorted by distance from this client.'],
        'origin_missing' => ['title' => 'Missing coordinates', 'body' => 'The selected client has no usable coordinates.'],
        'origin_missing_geocode_failed' => [
            'title' => 'Geocoding failed',
            'body' => 'Could not geocode the client address. Check the address or use "Update Coordinates" to populate all missing coordinates.',
        ],
        'view' => 'View',
        'view_tooltip' => 'View client profile',
        'edit' => 'Edit',
        'edit_tooltip' => 'Edit client',
];
