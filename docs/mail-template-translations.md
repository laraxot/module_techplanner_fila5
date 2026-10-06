# Traduzioni Template Email TechPlanner

Questo documento descrive la struttura delle traduzioni per i template email del modulo **TechPlanner**.

## Scopo

- Fornire etichette, placeholder, tooltip e testi di aiuto per la `MailTemplateResource` di TechPlanner.
- Allineare la struttura alle regole globali di traduzione (campi espansi, azioni, messaggi).
- Documentare i parametri dinamici utilizzabili nei contenuti dei template.

## File di Traduzione

- Percorso: `Modules/TechPlanner/lang/it/mail_template.php`
- Namespace: `techplanner::mail_template.*`

## Struttura

```php
return [
    'navigation' => [...],
    'model' => [...],
    'fields' => [...],
    'actions' => [...],
    'messages' => [...],
    'descriptions' => [...],
];
```

### Navigation

- **group**: sempre `techplanner`
- **label**: "Template email"
- **icon**: `techplanner-mail-template` (icona registrata nel panel)

### Campi Principali

- `mailable`: classe Mailable utilizzata per inviare l'email
- `name`: nome leggibile del template
- `slug`: identificatore univoco (es. `techplanner-promemoria`)
- `subject`: oggetto dell'email
- `html_template`: contenuto HTML
- `text_template`: contenuto solo testo
- `sms_template`: contenuto SMS opzionale
- `params`: elenco dei parametri/placeholder disponibili

Per ogni campo sono definiti:

- `label`
- `placeholder`
- `tooltip`
- `helper_text`
- `help`

### Azioni

- `create`: creazione nuovo template
- `edit`: modifica template esistente
- `delete`: eliminazione template
- `preview`: anteprima contenuto
- `send_test`: invio email di test

Ogni azione segue la struttura espansa prevista dalle regole globali:

- `label`, `icon`, `color`, `tooltip`
- `modal[heading|description|confirm|cancel]`
- `messages[success|error]`

### Messaggi

Messaggi standard per stato lista, creazione, aggiornamento, eliminazione ed errori generali.

## Collegamenti

- Regole globali traduzioni: `../../docs/translation_standards.md`
- Pattern generali Laraxot/Lang: `../../Modules/Lang/docs/translations.md` (se presente)
- Resource base Notify `MailTemplateResource`: `../app/Filament/Resources/MailTemplateResource.php` e `../../Notify/app/Filament/Resources/MailTemplateResource.php`

## Note

- Tutte le chiavi sono in inglese, i valori in italiano.
- Nessuna chiave deve avere `helper_text` uguale al nome della chiave stessa.
- Le stringhe visibili all'utente **non** devono essere hard-coded nelle Resource, ma lette dai file di traduzione.
