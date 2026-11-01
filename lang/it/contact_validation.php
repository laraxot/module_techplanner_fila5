<?php

declare(strict_types=1);

// Messaggi di errore e nomi dei campi del form di contatto (validazione lato server).
return [
    'rules' => [
        'required' => [
            'message' => 'Il campo :attribute è obbligatorio.',
        ],
        'email' => [
            'message' => 'Il campo :attribute deve contenere un indirizzo e-mail valido.',
        ],
        'string' => [
            'message' => 'Il campo :attribute non è valido.',
        ],
        'regex' => [
            'message' => 'Il campo :attribute contiene caratteri non validi.',
        ],
        'max' => [
            'message' => 'Il campo :attribute è troppo lungo.',
        ],
        'privacy_accepted' => [
            'message' => 'Per inviare il messaggio devi accettare l\'informativa sulla privacy.',
        ],
    ],
    'attributes' => [
        'nome' => [
            'label' => 'Nome e cognome',
        ],
        'email' => [
            'label' => 'Email',
        ],
        'telefono' => [
            'label' => 'Telefono',
        ],
        'studio' => [
            'label' => 'Nome studio',
        ],
        'tipo' => [
            'label' => 'Tipo',
        ],
        'messaggio' => [
            'label' => 'Messaggio',
        ],
        'privacy' => [
            'label' => 'Informativa sulla privacy',
        ],
    ],
];
