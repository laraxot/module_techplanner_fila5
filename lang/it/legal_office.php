<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Studio Legale',
        'group' => 'TechPlanner',
        'icon' => 'heroicon-o-building-office',
        'sort' => 9,
    ],
    'resource' => [
        'label' => 'Studio Legale',
        'plural_label' => 'Studi Legali',
        'navigation_group' => 'TechPlanner',
        'navigation_icon' => 'heroicon-o-building-office',
        'navigation_sort' => 9,
        'description' => 'Gestione degli studi legali',
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo Studio Legale',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
            'tooltip' => 'Crea un nuovo studio legale',
        ],
        'edit' => [
            'label' => 'Modifica',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning',
            'tooltip' => 'Modifica studio legale',
        ],
        'delete' => [
            'label' => 'Elimina',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'tooltip' => 'Elimina studio legale',
        ],
        'view' => [
            'label' => 'Visualizza',
            'icon' => 'heroicon-o-eye',
            'color' => 'info',
            'tooltip' => 'Visualizza studio legale',
        ],
        'reorderRecords' => [
            'tooltip' => 'reorderRecords',
        ],
        'detach' => [
            'tooltip' => 'detach',
        ],
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome Studio',
            'placeholder' => 'Inserisci il nome dello studio legale',
            'help' => 'Nome completo dello studio legale',
        ],
        'address' => [
            'label' => 'Indirizzo',
            'placeholder' => 'Inserisci l\'indirizzo completo',
            'help' => 'Indirizzo completo dello studio legale',
        ],
        'phone' => [
            'label' => 'Telefono',
            'placeholder' => 'Inserisci il numero di telefono',
            'help' => 'Numero di telefono principale',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci l\'indirizzo email',
            'help' => 'Indirizzo email principale dello studio',
        ],
        'website' => [
            'label' => 'Sito Web',
            'placeholder' => 'Inserisci l\'URL del sito web',
            'help' => 'URL del sito web dello studio',
        ],
        'vat_number' => [
            'label' => 'Partita IVA',
            'placeholder' => 'Inserisci la partita IVA',
            'help' => 'Partita IVA dello studio legale',
        ],
        'fiscal_code' => [
            'label' => 'Codice Fiscale',
            'placeholder' => 'Inserisci il codice fiscale',
            'help' => 'Codice fiscale dello studio legale',
        ],
        'is_active' => [
            'label' => 'Attivo',
            'help' => 'Se lo studio legale è attivo',
        ],
    ],
    'filters' => [
        'is_active' => [
            'label' => 'Stato',
            'options' => [
                'active' => 'Attivo',
                'inactive' => 'Inattivo',
            ],
        ],
        'city' => [
            'label' => 'Città',
            'placeholder' => 'Seleziona una città',
        ],
    ],
    'messages' => [
        'created' => 'Studio legale creato con successo',
        'updated' => 'Studio legale aggiornato con successo',
        'deleted' => 'Studio legale eliminato con successo',
        'not_found' => 'Studio legale non trovato',
        'validation_error' => 'Errore di validazione nei dati inseriti',
    ],
];
