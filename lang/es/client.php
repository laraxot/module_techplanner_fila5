<?php

declare(strict_types=1);

return [
    'actions' => [
        'geocodeCoordinates' => [
            'label' => 'Actualizar desde dirección',
            'failed_title' => 'Geocodificación fallida',
            'success_title' => 'Coordenadas actualizadas desde la dirección',
        ],
        'populateCoordinates' => [
            'modal' => ['heading' => 'Actualizar coordenadas', 'description' => '¿Actualizar las coordenadas de todos los clientes a partir de sus direcciones?', 'submit_label' => 'Sí, actualizar todo'],
        ],
    ],
    'fields' => [
        'latitude' => [
            'label' => 'Latitud',
        ],
        'longitude' => [
            'label' => 'Longitud',
        ],
        'last_rx_control_date' => [
            'label' => 'Último control de rayos X',
        ],
        'last_intraoral_control_date' => [
            'label' => 'Último control intraoral',
        ],
        'last_electromedical_control_date' => [
            'label' => 'Último control electromédico',
        ],
        'last_health_authorization_date' => [
            'label' => 'Última autorización sanitaria',
        ],
    ],
    'filters' => [
        'has_controls' => ['label' => 'Tiene controles registrados'],
        'controls_expiring' => ['label' => 'Controles que vencen (30 días)'],
        'never_controlled_type' => ['label' => 'Nunca controlado por tipo'],
        'has_rx_control' => ['label' => 'Control RX'],
        'has_electromedical_control' => ['label' => 'Control electromédico'],
        'has_health_authorization' => ['label' => 'Autorización sanitaria'],
    ],
    'map' => [
        'markers_shown' => 'Mostrando :count marcadores de clientes con coordenadas',
        'aria_label' => 'Mapa de clientes',
        'set_origin' => 'Usar como origen',
        'set_origin_tooltip' => 'Ordenar todos los clientes por distancia desde este punto',
        'origin_popup' => 'Punto de referencia para la distancia',
        'origin_set' => ['title' => 'Punto de origen establecido', 'body' => 'La tabla se ha ordenado por distancia desde este cliente.'],
        'origin_missing' => ['title' => 'Coordenadas no disponibles', 'body' => 'El cliente seleccionado no tiene coordenadas utilizables.'],
        'origin_missing_geocode_failed' => [
            'title' => 'Geocodificación fallida',
            'body' => 'No se pudo geocodificar la dirección del cliente. Comprueba la dirección o usa "Actualizar coordenadas" para rellenar todas las coordenadas faltantes.',
        ],
    ],
    'location_map' => [
        'heading' => 'Ubicación del cliente',
        'aria_label' => 'Mapa de la ubicación del cliente',
        'google_maps' => 'Abrir en Google Maps',
        'viamichelin' => 'Abrir en ViaMichelin',
        'missing' => 'No hay coordenadas. Completa la dirección y usa “Actualizar desde dirección” en la sección Coordenadas.',
    ],
    'messages' => [
        'coordinates_batch_summary' => 'Procesados :processed clientes. Coordenadas actualizadas para :success.',
        'coordinates_batch_warning' => 'Actualización de coordenadas completada con errores',
        'coordinates_batch_success' => 'Coordenadas actualizadas correctamente',
    ],
    'sections' => [
        'coordinates' => [
            'label' => 'Coordenadas',
            'description' => 'Latitud y longitud del cliente. Guarda primero la dirección y actualiza aquí las coordenadas para distancia y mapa.',
        ],
        'contacts' => [
            'heading' => 'Contactos',
            'label' => 'Contactos',
        ],
        'address_info' => [
            'label' => 'Dirección',
        ],
        'additional_info' => [
            'label' => 'Información adicional',
        ],
    ],
];
