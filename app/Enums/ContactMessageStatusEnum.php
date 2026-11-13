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

    /** Etichetta per il pannello, dal file lang `techplanner::contact_message.status`. */
    public static function label(self $state): string
    {
        $label = __('techplanner::contact_message.status.'.$state->value);

        return is_string($label) ? $label : $state->value;
    }

    public static function color(self $state): string
    {
        return match ($state) {
            self::Forwarded => 'success',
            self::Pending => 'warning',
            self::ForwardFailed => 'danger',
        };
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = self::label($case);
        }

        return $options;
    }
}
