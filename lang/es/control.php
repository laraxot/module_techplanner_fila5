<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => 'techplanner',
        'label' => 'Controles',
        'icon' => 'techplanner-control',
        'sort' => 40,
    ],
    'fields' => [
        'client_id' => ['label' => 'Cliente'],
        'device_id' => ['label' => 'Dispositivo'],
        'worker_id' => ['label' => 'Técnico'],
        'appointment_id' => ['label' => 'Cita'],
        'control_type' => ['label' => 'Tipo de control'],
        'status' => ['label' => 'Estado'],
        'result' => ['label' => 'Resultado'],
        'control_date' => ['label' => 'Fecha del control'],
        'next_control_date' => ['label' => 'Próximo control'],
        'notes' => ['label' => 'Notas'],
    ],
    'filters' => [
        'schedule_status' => ['label' => 'Estado de planificación', 'value' => 'Estado'],
        'expiring' => ['label' => 'Por vencer (30 días)'],
        'expired' => ['label' => 'Vencidos'],
    ],
    'widget' => [
        'heading' => 'Controles por vencer',
        'expired' => 'Vencidos',
        'expiring' => 'Por vencer (30 días)',
        'unplanned' => 'Sin próxima fecha',
        'clients_affected' => 'Clientes afectados',
    ],
    'reminder' => [
        'subject' => 'Controles por vencer',
        'body' => ':count controles vencen antes del :date (:expired ya vencidos).',
        'action_text' => 'Ver controles',
    ],
];
