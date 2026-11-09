<?php

declare(strict_types=1);

return [
    'actions' => [
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
        'last_appointment' => [
            'label' => 'Última cita',
        ],
        'last_health_authorization_date' => [
            'label' => 'Última autorización sanitaria',
        ],
    ],
    'filters' => [
        'has_controls' => ['label' => 'Tiene controles registrados'],
        'controls_expiring' => ['label' => 'Controles que vencen (30 días)'],
        'last_appointment_type' => ['label' => 'Última cita por tipo', 'none' => 'Sin cita'],
        'never_controlled_type' => ['label' => 'Nunca controlado por tipo'],
        'has_rx_control' => ['label' => 'Control RX'],
        'has_electromedical_control' => ['label' => 'Control electromédico'],
        'has_health_authorization' => ['label' => 'Autorización sanitaria'],
    ],
    'messages' => [
        'coordinates_batch_summary' => 'Procesados :processed clientes. Coordenadas actualizadas para :success.',
        'coordinates_batch_warning' => 'Actualización de coordenadas completada con errores',
        'coordinates_batch_success' => 'Coordenadas actualizadas correctamente',
    ],
    'sections' => [        'contacts' => [
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
