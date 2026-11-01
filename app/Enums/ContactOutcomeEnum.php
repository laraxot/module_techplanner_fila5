<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Enums;

/**
 * Esito di un invio dal form di contatto, passato alla vista come dato di sessione (`contact_outcome`).
 * La vista mostra un testo localizzato per ciascun caso; gli errori di validazione viaggiano a parte in `$errors`.
 *
 * Sent: archiviato (se possibile) e inoltrato per e-mail. Received: archiviato ma NON inoltrato (casella non
 * configurata o trasporto fallito): l'utente non deve leggere "inviato". Failed: ne' archiviato ne' inoltrato.
 */
enum ContactOutcomeEnum: string
{
    case Sent = 'sent';
    case Received = 'received';
    case Failed = 'failed';
}
