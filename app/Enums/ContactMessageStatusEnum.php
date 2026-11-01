<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Enums;

/**
 * Stato di inoltro di un messaggio archiviato dal form di contatto.
 * Pending: salvato, inoltro non tentato (casella di destinazione non configurata).
 * Forwarded: salvato e consegnato al trasporto e-mail. ForwardFailed: salvato, il trasporto ha rifiutato l'invio.
 */
enum ContactMessageStatusEnum: string
{
    case Pending = 'pending';
    case Forwarded = 'forwarded';
    case ForwardFailed = 'forward_failed';
}
