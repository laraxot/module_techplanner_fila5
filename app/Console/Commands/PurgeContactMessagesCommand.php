<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Console\Commands;

use Illuminate\Console\Command;
use Modules\TechPlanner\Actions\Contact\PurgeExpiredContactMessagesAction;

class PurgeContactMessagesCommand extends Command
{
    protected $signature = 'techplanner:contact-messages:purge {--dry-run : Conta i messaggi scaduti senza cancellarli}';

    protected $description = 'Cancella i messaggi del form di contatto oltre il periodo di conservazione (inerte se non configurato)';

    public function handle(PurgeExpiredContactMessagesAction $action): int
    {
        $count = $action->execute((bool) $this->option('dry-run'));

        if ($count === null) {
            $this->warn('Conservazione non configurata (TECHPLANNER_CONTACT_RETENTION_DAYS): nessuna cancellazione.');

            return self::SUCCESS;
        }

        $this->info(($this->option('dry-run') ? 'Messaggi scaduti: ' : 'Messaggi cancellati: ').$count);

        return self::SUCCESS;
    }
}
