<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Actions\Contact;

use Modules\TechPlanner\Models\ContactMessage;

/**
 * Cancella i messaggi piu' vecchi di `techplanner.contact.retention_days`. INERTE finche' la chiave e' vuota o non
 * e' un intero positivo: il periodo di conservazione e' una decisione del titolare (DA CONFERMARE) e non ha default.
 * Non e' schedulato: si pianifica solo dopo la decisione.
 */
final class PurgeExpiredContactMessagesAction
{
    public function retentionDays(): ?int
    {
        $days = config('techplanner.contact.retention_days');

        if (! is_numeric($days) || (int) $days < 1) {
            return null;
        }

        return (int) $days;
    }

    /**
     * @return int|null numero di messaggi scaduti (cancellati, o solo contati con $dryRun); null se la conservazione non e' configurata
     */
    public function execute(bool $dryRun = false): ?int
    {
        $days = $this->retentionDays();
        if ($days === null) {
            return null;
        }

        $expired = ContactMessage::query()->where('created_at', '<', now()->subDays($days));

        if ($dryRun) {
            return $expired->count();
        }

        $deleted = $expired->delete();

        return is_int($deleted) ? $deleted : null;
    }
}
