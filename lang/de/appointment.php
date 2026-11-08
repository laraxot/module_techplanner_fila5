<?php

declare(strict_types=1);

return [
    'options' => [
        'statuses' => [
            'scheduled' => 'Geplant',
            'confirmed' => 'Bestätigt',
            'completed' => 'Abgeschlossen',
            'cancelled' => 'Storniert',
        ],
        'time_slots' => [
            '09:00' => '09:00',
            '09:30' => '09:30',
            '10:00' => '10:00',
            '10:30' => '10:30',
            '11:00' => '11:00',
            '11:30' => '11:30',
            '14:00' => '14:00',
            '14:30' => '14:30',
            '15:00' => '15:00',
            '15:30' => '15:30',
            '16:00' => '16:00',
            '16:30' => '16:30',
        ],
        'priorities' => [
            'low' => 'Niedrig',
            'medium' => 'Mittel',
            'high' => 'Hoch',
            'urgent' => 'Dringend',
        ],
    ],
    'fields' => [
        'duration_minutes' => [
            'label' => 'Dauer (Minuten)',
            'suffix' => 'Min.',
        ],
    ],
    'validation' => [
        'conflict' => 'Der Mitarbeiter :worker hat am :date bereits einen Termin in diesem Zeitfenster.',
    ],
    'reminder' => [
        'subject' => 'Terminerinnerung',
        'client_body' => 'Sehr geehrte(r) :client, wir erinnern Sie an Ihren Termin am :date.',
        'admin_subject' => 'Termine für den :date',
        'admin_body' => 'Geplante Termine (:count):',
        'action_text' => 'Termine ansehen',
    ],
];
