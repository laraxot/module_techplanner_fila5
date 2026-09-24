<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => 'techplanner',
        'label' => 'Template email',
        'icon' => 'techplanner-mail-template',
        'sort' => 80,
    ],
    'model' => [
        'label' => 'Template email',
        'plural' => 'Template email',
        'description' => 'Gestione dei template email specifici per TechPlanner.',
    ],
    'fields' => [
        'mailable' => [
            'label' => 'Classe Mailable',
            'placeholder' => 'Inserisci la classe Mailable completa',
            'tooltip' => 'Classe PHP che verrà utilizzata per inviare l\'email.',
            'helper_text' => 'Ad esempio: Modules\\Notify\\Emails\\SpatieEmail',
            'help' => 'Specifica la classe Mailable responsabile della costruzione del messaggio.',
        ],
        'name' => [
            'label' => 'Nome template',
            'placeholder' => 'Inserisci un nome descrittivo per il template',
            'tooltip' => 'Nome leggibile del template email.',
            'helper_text' => 'Usa un nome che ti permetta di riconoscere rapidamente il template.',
            'help' => 'Questo nome è visualizzato nelle liste interne di gestione template.',
        ],
        'slug' => [
            'label' => 'Slug',
            'placeholder' => 'Inserisci lo slug del template (es. techplanner-promemoria)',
            'tooltip' => 'Identificatore univoco del template email.',
            'helper_text' => 'Verrà usato per referenziare il template da codice e configurazioni.',
            'help' => 'Utilizza solo lettere minuscole, numeri e trattini.',
        ],
        'subject' => [
            'label' => 'Oggetto',
            'placeholder' => 'Inserisci l\'oggetto dell\'email',
            'tooltip' => 'Oggetto che verrà mostrato nel client di posta del destinatario.',
            'helper_text' => 'Puoi utilizzare placeholder come :client_name o :date.',
            'help' => 'Mantieni l\'oggetto chiaro e sintetico.',
        ],
        'html_template' => [
            'label' => 'Template HTML',
            'placeholder' => 'Inserisci il contenuto HTML dell\'email',
            'tooltip' => 'Contenuto HTML del messaggio email.',
            'helper_text' => 'Puoi utilizzare placeholder per i dati dinamici (es. :client_name, :appointment_date).',
            'help' => 'Assicurati che il markup sia compatibile con i principali client di posta.',
        ],
        'text_template' => [
            'label' => 'Template testo',
            'placeholder' => 'Inserisci il contenuto in solo testo',
            'tooltip' => 'Versione testuale del messaggio email.',
            'helper_text' => 'Utilizzata dai client che non supportano HTML o per accessibilità.',
            'help' => 'Mantieni il contenuto coerente con il template HTML.',
        ],
        'sms_template' => [
            'label' => 'Template SMS',
            'placeholder' => 'Inserisci il contenuto del messaggio SMS',
            'tooltip' => 'Contenuto opzionale per l\'invio di SMS associati al template.',
            'helper_text' => 'Ricorda i limiti di lunghezza degli SMS e l\'assenza di formattazione.',
            'help' => 'Usa un linguaggio sintetico e chiaro.',
        ],
        'params' => [
            'label' => 'Parametri disponibili',
            'placeholder' => 'Elenco dei parametri disponibili per questo template',
            'tooltip' => 'Parametri dinamici che possono essere utilizzati nel contenuto del template.',
            'helper_text' => 'I parametri vengono mostrati automaticamente in base alla configurazione del template.',
            'help' => 'Usa questi placeholder nel contenuto HTML, testo o SMS per inserire valori dinamici.',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo template email',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
            'tooltip' => 'Crea un nuovo template email per TechPlanner.',
            'modal' => [
                'heading' => 'Crea nuovo template email',
                'description' => 'Definisci nome, slug e contenuti del template email.',
                'confirm' => 'Crea template',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Template email creato con successo.',
                'error' => 'Si è verificato un errore durante la creazione del template email.',
            ],
        ],
        'edit' => [
            'label' => 'Modifica template email',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning',
            'tooltip' => 'Modifica il template email selezionato.',
            'modal' => [
                'heading' => 'Modifica template email',
                'description' => 'Aggiorna i dettagli e i contenuti del template.',
                'confirm' => 'Salva modifiche',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Template email aggiornato con successo.',
                'error' => 'Si è verificato un errore durante l\'aggiornamento del template email.',
            ],
        ],
        'delete' => [
            'label' => 'Elimina template',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'tooltip' => 'Elimina il template email selezionato.',
            'modal' => [
                'heading' => 'Elimina template email',
                'description' => 'Sei sicuro di voler eliminare questo template email? Questa azione è irreversibile.',
                'confirm' => 'Elimina',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Template email eliminato con successo.',
                'error' => 'Si è verificato un errore durante l\'eliminazione del template email.',
            ],
            'confirmation' => 'Confermi l\'eliminazione definitiva di questo template email?',
        ],
        'preview' => [
            'label' => 'Anteprima',
            'icon' => 'heroicon-o-eye',
            'color' => 'secondary',
            'tooltip' => 'Visualizza l\'anteprima del template email.',
        ],
        'send_test' => [
            'label' => 'Invia email di test',
            'icon' => 'heroicon-o-paper-airplane',
            'color' => 'success',
            'tooltip' => 'Invia una email di test utilizzando questo template.',
            'messages' => [
                'success' => 'Email di test inviata con successo.',
                'error' => 'Si è verificato un errore durante l\'invio dell\'email di test.',
            ],
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'profile' => [
            'tooltip' => 'profile',
            'icon' => 'profile',
            'label' => 'profile',
        ],
        'reorderRecords' => [
            'tooltip' => 'reorderRecords',
            'icon' => 'reorderRecords',
            'label' => 'reorderRecords',
        ],
        'cancel' => [
            'tooltip' => 'cancel',
            'icon' => 'cancel',
            'label' => 'cancel',
        ],
        'openColumnManager' => [
            'tooltip' => 'openColumnManager',
            'icon' => 'openColumnManager',
            'label' => 'openColumnManager',
        ],
        'applyTableColumnManager' => [
            'tooltip' => 'applyTableColumnManager',
            'icon' => 'applyTableColumnManager',
            'label' => 'applyTableColumnManager',
        ],
        'save' => [
            'tooltip' => 'save',
            'icon' => 'save',
            'label' => 'save',
        ],
        'activeLocale' => [
            'tooltip' => 'activeLocale',
            'icon' => 'activeLocale',
            'label' => 'activeLocale',
        ],
        'resetFilters' => [
            'tooltip' => 'resetFilters',
            'icon' => 'resetFilters',
            'label' => 'resetFilters',
        ],
        'applyFilters' => [
            'tooltip' => 'applyFilters',
        ],
    ],
    'messages' => [
        'empty_state' => 'Nessun template email TechPlanner definito al momento.',
        'search_placeholder' => 'Cerca nei template email...',
        'loading' => 'Caricamento template email in corso...',
        'total_count' => 'Totale template email: :count',
        'created' => 'Template email creato correttamente.',
        'updated' => 'Template email aggiornato correttamente.',
        'deleted' => 'Template email eliminato correttamente.',
        'error_general' => 'Si è verificato un errore. Riprova più tardi.',
    ],
    'descriptions' => [
        'purpose' => 'I template email TechPlanner permettono di centralizzare e riutilizzare la comunicazione verso clienti e contatti.',
        'scoping' => 'Questo elenco mostra solo i template il cui slug inizia con "techplanner-".',
        'best_practices' => 'Mantieni i template riutilizzabili, utilizza placeholder chiari e documenta i parametri disponibili.',
    ],
    'label' => 'mail template',
];
