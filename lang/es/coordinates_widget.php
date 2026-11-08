<?php

declare(strict_types=1);

return [
    'sections' => [
        'title' => [
            'title' => 'Posición de referencia',
        ],
    ],
    'actions' => [
        'update_button' => [
            'label' => 'Actualizar posición',
        ],
    ],
    'fields' => ['latitude' => 'Latitud', 'longitude' => 'Longitud'],
    'notifications' => [
        'invalid' => ['title' => 'Coordenadas no válidas', 'body' => 'La latitud debe estar entre -90 y 90 y la longitud entre -180 y 180.'],
        'updated' => ['title' => 'Coordenadas actualizadas', 'body' => 'La tabla se ordenó por distancia desde las coordenadas seleccionadas.'],
    ],
];
