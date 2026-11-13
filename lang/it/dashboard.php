<?php

declare(strict_types=1);

return [
    'stats' => [
        'overdue' => [
            'label' => 'Verifiche scadute',
            'description' => 'Apparecchi da verificare subito',
        ],
        'due_soon' => [
            'label' => 'In scadenza',
            'description' => 'Entro :days giorni',
        ],
        'never' => [
            'label' => 'Mai verificati',
            'description' => 'Apparecchi senza nessuna verifica',
        ],
        'appointments_today' => [
            'label' => 'Appuntamenti di oggi',
            'description' => 'Apri l\'elenco degli appuntamenti',
        ],
    ],
    'due_devices' => [
        'heading' => 'Da verificare (scadute ed entro :days giorni)',
    ],
    'today_appointments' => [
        'heading' => 'Il giro di oggi',
        'columns' => [
            'time' => 'Ora',
        ],
    ],
];
