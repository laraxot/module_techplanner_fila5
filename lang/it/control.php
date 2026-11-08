<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => 'techplanner',
        'label' => 'Controlli',
        'icon' => 'techplanner-control',
        'sort' => 40,
    ],
    'fields' => [
        'client_id' => ['label' => 'Cliente'],
        'device_id' => ['label' => 'Dispositivo'],
        'worker_id' => ['label' => 'Tecnico'],
        'appointment_id' => ['label' => 'Appuntamento'],
        'control_type' => ['label' => 'Tipo di controllo'],
        'status' => ['label' => 'Stato'],
        'result' => ['label' => 'Esito'],
        'control_date' => ['label' => 'Data controllo'],
        'next_control_date' => ['label' => 'Prossimo controllo'],
        'notes' => ['label' => 'Note'],
    ],
    'filters' => [
        'schedule_status' => ['label' => 'Stato pianificazione', 'value' => 'Stato'],
        'expiring' => ['label' => 'In scadenza (30 gg)'],
        'expired' => ['label' => 'Scaduti'],
    ],
    'widget' => [
        'heading' => 'Controlli in scadenza',
        'expired' => 'Scaduti',
        'expiring' => 'In scadenza (30 gg)',
        'unplanned' => 'Senza prossima data',
        'clients_affected' => 'Clienti interessati',
    ],
    'reminder' => [
        'subject' => 'Controlli in scadenza',
        'body' => ':count controlli in scadenza entro il :date (:expired scaduti).',
        'action_text' => 'Vedi controlli',
    ],
];
