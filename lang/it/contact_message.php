<?php

declare(strict_types=1);

return [
    'label' => 'Richiesta dal sito',
    'plural_label' => 'Richieste dal sito',
    'navigation' => [
        'group' => 'Lavoro quotidiano',
        'label' => 'Richieste dal sito',
        'plural_label' => 'Richieste dal sito',
        'icon' => 'heroicon-o-inbox',
        'sort' => 45,
    ],
    'empty' => [
        'heading' => 'Nessuna richiesta',
        'description' => 'Qui arrivano i messaggi inviati dal modulo «Contatti» del sito.',
    ],
    'status' => [
        'pending' => 'Da inoltrare',
        'forwarded' => 'Inoltrata per e-mail',
        'forward_failed' => 'Inoltro fallito',
    ],
    'mail' => [
        'subject' => [
            'label' => 'Nuovo messaggio dal modulo di contatto del sito',
        ],
        'intro' => [
            'message' => 'Hai ricevuto un messaggio dal modulo di contatto del sito. Per rispondere usa «Rispondi»: l\'indirizzo del mittente e\' quello indicato nel modulo.',
        ],
        'fields' => [
            'name' => [
                'label' => 'Nome e cognome',
            ],
            'email' => [
                'label' => 'Email',
            ],
            'phone' => [
                'label' => 'Telefono',
            ],
            'studio' => [
                'label' => 'Studio',
            ],
            'type' => [
                'label' => 'Tipo',
            ],
            'page_locale' => [
                'label' => 'Lingua della pagina',
            ],
            'privacy' => [
                'label' => 'Informativa privacy',
            ],
            'message' => [
                'label' => 'Messaggio',
            ],
        ],
        'privacy_seen' => [
            'message' => 'letta e accettata dal mittente il :when',
        ],
    ],
    'fields' => [
        'value' => [
            'label' => 'Valore',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'applyFilters' => [
            'label' => 'applyFilters',
            'icon' => 'applyFilters',
            'tooltip' => '',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
            'icon' => 'resetFilters',
            'tooltip' => '',
        ],
        'openFilters' => [
            'label' => 'openFilters',
            'icon' => 'openFilters',
            'tooltip' => '',
        ],
        'applyTableColumnManager' => [
            'label' => 'applyTableColumnManager',
            'icon' => 'applyTableColumnManager',
            'tooltip' => '',
        ],
        'openColumnManager' => [
            'label' => 'openColumnManager',
            'icon' => 'openColumnManager',
            'tooltip' => '',
        ],
        'resetColumnManager' => [
            'label' => 'resetColumnManager',
            'icon' => 'resetColumnManager',
            'tooltip' => '',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
            'icon' => 'reorderRecords',
            'tooltip' => '',
        ],
        'profile' => [
            'label' => 'profile',
            'icon' => 'profile',
            'tooltip' => '',
        ],
        'logout' => [
            'label' => 'logout',
            'icon' => 'logout',
            'tooltip' => '',
        ],
        'back' => [
            'label' => 'back',
            'icon' => 'back',
            'tooltip' => '',
        ],
    ],
];
