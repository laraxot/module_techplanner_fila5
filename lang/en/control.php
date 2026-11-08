<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => 'techplanner',
        'label' => 'Controls',
        'icon' => 'techplanner-control',
        'sort' => 40,
    ],
    'fields' => [
        'client_id' => ['label' => 'Client'],
        'device_id' => ['label' => 'Device'],
        'worker_id' => ['label' => 'Technician'],
        'appointment_id' => ['label' => 'Appointment'],
        'control_type' => ['label' => 'Control type'],
        'status' => ['label' => 'Status'],
        'result' => ['label' => 'Result'],
        'control_date' => ['label' => 'Control date'],
        'next_control_date' => ['label' => 'Next control'],
        'notes' => ['label' => 'Notes'],
    ],
    'filters' => [
        'schedule_status' => ['label' => 'Schedule status', 'value' => 'Status'],
        'expiring' => ['label' => 'Expiring (30 days)'],
        'expired' => ['label' => 'Expired'],
    ],
    'widget' => [
        'heading' => 'Expiring controls',
        'expired' => 'Expired',
        'expiring' => 'Expiring (30 days)',
        'unplanned' => 'No next date',
        'clients_affected' => 'Clients affected',
    ],
    'reminder' => [
        'subject' => 'Expiring controls',
        'body' => ':count controls expiring by :date (:expired already expired).',
        'action_text' => 'View controls',
    ],
];
