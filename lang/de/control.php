<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => 'techplanner',
        'label' => 'Kontrollen',
        'icon' => 'techplanner-control',
        'sort' => 40,
    ],
    'fields' => [
        'client_id' => ['label' => 'Kunde'],
        'device_id' => ['label' => 'Gerät'],
        'worker_id' => ['label' => 'Techniker'],
        'appointment_id' => ['label' => 'Termin'],
        'control_type' => ['label' => 'Kontrolltyp'],
        'status' => ['label' => 'Status'],
        'result' => ['label' => 'Ergebnis'],
        'control_date' => ['label' => 'Kontrolldatum'],
        'next_control_date' => ['label' => 'Nächste Kontrolle'],
        'notes' => ['label' => 'Notizen'],
    ],
    'filters' => [
        'schedule_status' => ['label' => 'Planungsstatus', 'value' => 'Status'],
        'expiring' => ['label' => 'Läuft ab (30 Tage)'],
        'expired' => ['label' => 'Abgelaufen'],
    ],
    'widget' => [
        'heading' => 'Ablaufende Kontrollen',
        'expired' => 'Abgelaufen',
        'expiring' => 'Läuft ab (30 Tage)',
        'unplanned' => 'Ohne nächstes Datum',
        'clients_affected' => 'Betroffene Kunden',
    ],
    'reminder' => [
        'subject' => 'Ablaufende Kontrollen',
        'body' => ':count Kontrollen laufen bis :date ab (:expired bereits abgelaufen).',
        'action_text' => 'Kontrollen ansehen',
    ],
];
