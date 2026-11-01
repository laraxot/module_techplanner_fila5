<?php

declare(strict_types=1);

// Messaggi di errore e nomi dei campi del form di contatto (validazione lato server).
return [
    'rules' => [
        'required' => [
            'message' => 'The :attribute field is required.',
        ],
        'email' => [
            'message' => 'The :attribute field must contain a valid email address.',
        ],
        'string' => [
            'message' => 'The :attribute field is not valid.',
        ],
        'regex' => [
            'message' => 'The :attribute field contains invalid characters.',
        ],
        'max' => [
            'message' => 'The :attribute field is too long.',
        ],
        'privacy_accepted' => [
            'message' => 'To send the message you must accept the privacy notice.',
        ],
    ],
    'attributes' => [
        'nome' => [
            'label' => 'full name',
        ],
        'email' => [
            'label' => 'email',
        ],
        'telefono' => [
            'label' => 'phone',
        ],
        'studio' => [
            'label' => 'practice name',
        ],
        'tipo' => [
            'label' => 'type',
        ],
        'messaggio' => [
            'label' => 'message',
        ],
        'privacy' => [
            'label' => 'privacy notice',
        ],
    ],
];
