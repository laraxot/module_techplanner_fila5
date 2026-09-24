<?php

declare(strict_types=1);

return [
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => 'Identificativo univoco del record.',
        ],
        'business_closed' => [
            'label' => 'Attività Chiusa',
            'tooltip' => 'Indica se l\'attività è chiusa.',
            'placeholder' => 'Es. Sì o No',
        ],
        'company_name' => [
            'label' => 'Nome Azienda',
            'tooltip' => 'Inserisci il nome completo dell\'azienda.',
            'placeholder' => 'Es. Rossi S.r.l.',
        ],
        'competent_health_unit' => [
            'label' => 'Unità Sanitaria Competente',
            'tooltip' => 'Specifica l\'unità sanitaria competente per l\'azienda.',
            'placeholder' => 'Inserisci il nome dell\'unità sanitaria',
        ],
        'tax_code' => [
            'label' => 'Codice Fiscale',
            'tooltip' => 'Inserisci il codice fiscale dell\'azienda.',
            'placeholder' => 'Es. RSSMRA85M01H501Z',
        ],
        'company_office' => [
            'label' => 'Sede Aziendale',
            'tooltip' => 'Indica la sede principale dell\'azienda.',
            'placeholder' => 'Es. Via Roma 10, Milano',
        ],
        'address' => [
            'label' => 'Indirizzo',
            'tooltip' => 'Inserisci l\'indirizzo completo.',
            'placeholder' => 'Es. Via Milano',
        ],
        'street_number' => [
            'label' => 'Numero Civico',
            'tooltip' => 'Specifica il numero civico.',
            'placeholder' => 'Es. 42',
        ],
        'postal_code' => [
            'label' => 'CAP',
            'tooltip' => 'Inserisci il codice di avviamento postale.',
            'placeholder' => 'Es. 20100',
        ],
        'fax' => [
            'label' => 'Fax',
            'tooltip' => 'Numero di fax aziendale (opzionale).',
            'placeholder' => 'Es. +39 02 1234567',
        ],
        'mobile' => [
            'label' => 'Cellulare',
            'tooltip' => 'Numero di cellulare di contatto.',
            'placeholder' => 'Es. +39 345 6789012',
        ],
        'notes' => [
            'label' => 'Note',
            'tooltip' => 'Aggiungi eventuali annotazioni.',
            'placeholder' => 'Scrivi qui eventuali note...',
        ],
        'country' => [
            'label' => 'Paese',
            'tooltip' => 'Specifica il paese.',
            'placeholder' => 'Es. Italia',
        ],
        'sortByDistance' => [
            'label' => 'sortByDistance',
            'tooltip' => 'Ordina i risultati in base alla distanza.',
        ],
        'email' => [
            'label' => 'Email',
            'tooltip' => 'Inserisci l\'indirizzo email di contatto.',
            'placeholder' => 'Es. esempio@email.com',
        ],
    ],
    'actions' => [
        'populateCoordinates' => [
            'label' => 'Popola Coordinate',
            'tooltip' => 'Calcola e inserisce automaticamente le coordinate geografiche.',
        ],
        'create' => [
            'label' => 'Crea',
            'tooltip' => 'Aggiungi un nuovo record.',
        ],
    ],
];
