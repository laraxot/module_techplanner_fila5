<?php

declare(strict_types=1);

// Messaggi di errore e nomi dei campi del form di contatto (validazione lato server).
return [
    'rules' => [
        'required' => [
            'message' => 'Das Feld :attribute ist erforderlich.',
        ],
        'email' => [
            'message' => 'Das Feld :attribute muss eine gültige E-Mail-Adresse enthalten.',
        ],
        'string' => [
            'message' => 'Das Feld :attribute ist ungültig.',
        ],
        'regex' => [
            'message' => 'Das Feld :attribute enthält ungültige Zeichen.',
        ],
        'max' => [
            'message' => 'Das Feld :attribute ist zu lang.',
        ],
        'privacy_accepted' => [
            'message' => 'Um die Nachricht zu senden, müssen Sie die Datenschutzerklärung akzeptieren.',
        ],
    ],
    'attributes' => [
        'nome' => [
            'label' => 'Vor- und Nachname',
        ],
        'email' => [
            'label' => 'E-Mail',
        ],
        'telefono' => [
            'label' => 'Telefon',
        ],
        'studio' => [
            'label' => 'Praxisname',
        ],
        'tipo' => [
            'label' => 'Typ',
        ],
        'messaggio' => [
            'label' => 'Nachricht',
        ],
        'privacy' => [
            'label' => 'Datenschutzerklärung',
        ],
    ],
];
