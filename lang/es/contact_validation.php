<?php

declare(strict_types=1);

// Messaggi di errore e nomi dei campi del form di contatto (validazione lato server).
return [
    'rules' => [
        'required' => [
            'message' => 'El campo :attribute es obligatorio.',
        ],
        'email' => [
            'message' => 'El campo :attribute debe contener un correo electrónico válido.',
        ],
        'string' => [
            'message' => 'El campo :attribute no es válido.',
        ],
        'regex' => [
            'message' => 'El campo :attribute contiene caracteres no válidos.',
        ],
        'max' => [
            'message' => 'El campo :attribute es demasiado largo.',
        ],
        'privacy_accepted' => [
            'message' => 'Para enviar el mensaje debes aceptar la información sobre privacidad.',
        ],
    ],
    'attributes' => [
        'nome' => [
            'label' => 'nombre y apellidos',
        ],
        'email' => [
            'label' => 'correo electrónico',
        ],
        'telefono' => [
            'label' => 'teléfono',
        ],
        'studio' => [
            'label' => 'nombre de la consulta',
        ],
        'tipo' => [
            'label' => 'tipo',
        ],
        'messaggio' => [
            'label' => 'mensaje',
        ],
        'privacy' => [
            'label' => 'información sobre privacidad',
        ],
    ],
];
