<?php

declare(strict_types=1);
use Illuminate\Support\Env;

/*
 * Form di contatto del sito (blocco `contact-form` del tema). Letto da `config('techplanner.contact.*')`.
 *
 * Nessun valore di default, volutamente: sono decisioni del titolare e vanno valorizzate nell'ambiente.
 * - `recipient` vuoto o non valido: il messaggio viene comunque archiviato, ma NON inoltrato, e l'utente non
 *   legge mai "inviato" (vede "ricevuto, non ancora inoltrato").
 * - `retention_days` vuoto: nessuna cancellazione, mai. Il comando `techplanner:contact-messages:purge` resta inerte.
 */
return [
    // Casella che riceve i messaggi. Variabile: TECHPLANNER_CONTACT_RECIPIENT.
    'recipient' => Env::get('TECHPLANNER_CONTACT_RECIPIENT'),

    // DA CONFERMARE (titolare): giorni di conservazione dei messaggi archiviati. Variabile: TECHPLANNER_CONTACT_RETENTION_DAYS.
    'retention_days' => Env::get('TECHPLANNER_CONTACT_RETENTION_DAYS'),
];
