<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Modules\Notify\Notifications\GenericNotification;
use Modules\TechPlanner\Filament\Resources\ControlResource;
use Modules\TechPlanner\Models\Control;
use Modules\User\Models\User;

/**
 * Digest giornaliero dei controlli in scadenza verso admin e super-admin.
 *
 * Equivalente agli "expiry alerts" dei concorrenti FSM/CMMS: un solo messaggio
 * aggregato al giorno (no spam per singolo controllo), con il conteggio per
 * tipo e il link diretto all'elenco controlli.
 */
class NotifyExpiringControlsCommand extends Command
{
    protected $signature = 'techplanner:controls:expiring-reminder {--days=30 : Orizzonte in giorni} {--dry-run : Mostra il riepilogo senza inviare notifiche}';

    protected $description = 'Invia un riepilogo dei controlli in scadenza agli administratori';

    public function handle(): int
    {
        $controlQuery = Control::query();
        if (! $controlQuery->getModel()->getConnection()->getSchemaBuilder()->hasTable('controls')) {
            $this->warn('La tabella controls non è ancora disponibile. Eseguire la migration prima del reminder.');

            return self::SUCCESS;
        }

        $days = max(1, (int) $this->option('days'));
        $horizon = Carbon::today()->addDays($days);

        /** @var Collection<int, Control> $controls */
        $controls = $controlQuery
            ->with('client:id,company_name,name')
            ->whereNotNull('next_control_date')
            ->whereDate('next_control_date', '<=', $horizon)
            ->orderBy('next_control_date')
            ->get();

        if ($controls->isEmpty()) {
            $this->info('Nessun controllo in scadenza.');

            return self::SUCCESS;
        }

        $expired = $controls->filter(
            static function (Control $control): bool {
                $date = $control->getAttribute('next_control_date');

                return $date instanceof Carbon && $date->isBefore(Carbon::today());
            },
        )->count();

        /** @var array<string, int> $byType */
        $byType = $controls
            ->groupBy(static function (Control $control): string {
                $type = $control->getAttribute('control_type');

                if ($type instanceof \BackedEnum) {
                    return (string) $type->value;
                }

                return is_scalar($type) ? (string) $type : '';
            })
            ->map(static fn (Collection $group): int => $group->count())
            ->all();

        $lines = collect($byType)
            ->map(static fn (int $count, string $type): string => "- {$type}: {$count}")
            ->implode("\n");

        $body = __('techplanner::control.reminder.body', [
            'count' => $controls->count(),
            'date' => $horizon->format('d/m/Y'),
            'expired' => $expired,
        ])."\n".$lines;

        if ($this->option('dry-run')) {
            $this->line($body);
            $this->info('Destinatari: '.User::role(['admin', 'super-admin'])->count());

            return self::SUCCESS;
        }

        $url = ControlResource::getUrl('index');
        $notification = new GenericNotification(
            title: __('techplanner::control.reminder.subject'),
            message: $body,
            channels: ['database', 'mail'],
            data: [
                'action_text' => __('techplanner::control.reminder.action_text'),
                'action_url' => $url,
            ],
        );

        $sent = 0;
        User::role(['admin', 'super-admin'])->chunk(100, function (Collection $users) use ($notification, &$sent): void {
            foreach ($users as $user) {
                $user->notify($notification);
                $sent++;
            }
        });

        $this->info("Notifiche inviate: {$sent} (controlli in scadenza: {$controls->count()}, di cui {$expired} scaduti).");

        return self::SUCCESS;
    }
}
