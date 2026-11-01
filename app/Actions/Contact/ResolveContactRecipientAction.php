<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Actions\Contact;

/**
 * Casella che riceve i messaggi del form di contatto, oppure null se il titolare non l'ha ancora confermata.
 * Chiamata dalla vista (per non offrire un form che non consegna) e da SubmitContactFormAction (per non fingere l'invio).
 */
final class ResolveContactRecipientAction
{
    public function execute(): ?string
    {
        $recipient = config('techplanner.contact.recipient');

        if (! is_string($recipient) || filter_var($recipient, FILTER_VALIDATE_EMAIL) === false) {
            return null;
        }

        return $recipient;
    }
}
