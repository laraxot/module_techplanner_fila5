<?php

declare(strict_types=1);

// Messaggio che arriva alla casella del titolare dal form di contatto (solo italiano: lo legge il titolare).
return [
    'mail' => [
        'subject' => [
            'label' => 'Nuovo messaggio dal modulo di contatto del sito',
        ],
        'intro' => [
            'message' => 'Hai ricevuto un messaggio dal modulo di contatto del sito. Per rispondere usa «Rispondi»: l\'indirizzo del mittente e\' quello indicato nel modulo.',
        ],
        'fields' => [
            'name' => ['label' => 'Nome e cognome'],
            'email' => ['label' => 'Email'],
            'phone' => ['label' => 'Telefono'],
            'studio' => ['label' => 'Studio'],
            'type' => ['label' => 'Tipo'],
            'page_locale' => ['label' => 'Lingua della pagina'],
            'privacy' => ['label' => 'Informativa privacy'],
            'message' => ['label' => 'Messaggio'],
        ],
        'privacy_seen' => [
            'message' => 'letta e accettata dal mittente il :when',
        ],
    ],
];
