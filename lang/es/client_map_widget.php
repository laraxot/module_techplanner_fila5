<?php

declare(strict_types=1);

return [
        'markers_shown' => 'Mostrando :count marcadores de clientes con coordenadas',
        'aria_label' => 'Mapa de clientes',
        'fullscreen' => 'Pantalla completa',
        'locate' => 'Centrar en mi ubicación',
        'layer_satellite' => 'Satélite',
        'set_origin' => 'Usar como origen',
        'set_origin_tooltip' => 'Ordenar todos los clientes por distancia desde este punto',
        'origin_popup' => 'Punto de referencia para la distancia',
        'origin_set' => ['title' => 'Punto de origen establecido', 'body' => 'La tabla se ha ordenado por distancia desde este cliente.'],
        'origin_missing' => ['title' => 'Coordenadas no disponibles', 'body' => 'El cliente seleccionado no tiene coordenadas utilizables.'],
        'origin_missing_geocode_failed' => [
            'title' => 'Geocodificación fallida',
            'body' => 'No se pudo geocodificar la dirección del cliente. Comprueba la dirección o usa "Actualizar coordenadas" para rellenar todas las coordenadas faltantes.',
        ],
        'view' => 'Ver',
        'view_tooltip' => 'Ver la ficha del cliente',
        'edit' => 'Editar',
        'edit_tooltip' => 'Editar el cliente',
];
