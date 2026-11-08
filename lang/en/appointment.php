<?php

declare(strict_types=1);

return [
    'options' => [
        'statuses' => [
            'scheduled' => 'Scheduled',
            'confirmed' => 'Confirmed',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
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
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High',
            'urgent' => 'Urgent',
        ],
    ],
    'fields' => [
        'duration_minutes' => [
            'label' => 'Duration (minutes)',
            'suffix' => 'min',
        ],
    ],
    'validation' => [
        'conflict' => 'The worker :worker already has an appointment on :date in this time slot.',
    ],
    'reminder' => [
        'subject' => 'Appointment reminder',
        'client_body' => 'Dear :client, this is a reminder of your appointment scheduled for :date.',
        'admin_subject' => 'Appointments agenda for :date',
        'admin_body' => 'Scheduled appointments (:count):',
        'action_text' => 'View appointments',
    ],
];
