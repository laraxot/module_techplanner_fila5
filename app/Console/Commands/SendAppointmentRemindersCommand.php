<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;
use Modules\Notify\Notifications\GenericNotification;
use Modules\TechPlanner\Filament\Resources\AppointmentResource;
use Modules\TechPlanner\Models\Appointment;
use Modules\TechPlanner\Models\Client;
use Modules\User\Models\User;
use Modules\Xot\Actions\Cast\SafeStringCastAction;

/**
 * Promemoria appuntamenti: email al cliente per gli appuntamenti del giorno
 * indicato (default: domani) ancora senza promemoria inviato, più un digest
 * interno agli admin con l'agenda del giorno.
 *
 * `reminder_sent_at` garantisce l'idempotenza: un appuntamento riceve un solo
 * promemoria automatico.
 */
class SendAppointmentRemindersCommand extends Command
{
    protected $signature = 'techplanner:appointments:reminders {--days=1 : Giorni di anticipo (1 = domani)} {--dry-run : Mostra cosa verrebbe inviato senza spedire}';

    protected $description = 'Invia i promemoria appuntamento ai clienti e il digest agenda agli admin';

    public function handle(): int
    {
        $appointmentQuery = Appointment::query();
        if (! $appointmentQuery->getModel()->getConnection()->getSchemaBuilder()->hasTable('appointments')) {
            $this->warn('La tabella appointments non è ancora disponibile.');

            return self::SUCCESS;
        }

        $days = max(0, (int) $this->option('days'));
        $target = Carbon::today()->addDays($days);

        /** @var Collection<int, Appointment> $appointments */
        $appointments = $appointmentQuery
            ->with(['client:id,company_name,name,email', 'worker:id,first_name,last_name'])
            ->whereDate('date', $target->toDateString())
            ->whereNull('reminder_sent_at')
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->orderBy('date')
            ->get();

        if ($appointments->isEmpty()) {
            $this->info('Nessun appuntamento da ricordare per il '.$target->format('d/m/Y').'.');

            return self::SUCCESS;
        }

        $url = AppointmentResource::getUrl('index');
        $sent = 0;
        $skipped = 0;

        foreach ($appointments as $appointment) {
            $client = $appointment->client;
            $email = $client?->getAttribute('email');

            if (! is_string($email) || $email === '') {
                $skipped++;
                $this->line('#'.SafeStringCastAction::cast($appointment->getKey()).' - nessuna email cliente, saltato');

                continue;
            }

            $when = $appointment->getAttribute('date');
            $whenLabel = $when instanceof Carbon ? $when->format('d/m/Y H:i') : '—';
            $clientName = self::clientDisplayName($client);

            if ($this->option('dry-run')) {
                $this->line('DRY-RUN #'.SafeStringCastAction::cast($appointment->getKey())." → {$email} ({$clientName}, {$whenLabel})");
                $sent++;

                continue;
            }

            Notification::route('mail', $email)->notify(new GenericNotification(
                title: __('techplanner::appointment.reminder.subject'),
                message: __('techplanner::appointment.reminder.client_body', [
                    'client' => $clientName,
                    'date' => $whenLabel,
                ]),
                channels: ['mail'],
                data: [
                    'action_text' => __('techplanner::appointment.reminder.action_text'),
                    'action_url' => $url,
                ],
            ));

            $appointment->setAttribute('reminder_sent_at', Carbon::now());
            $appointment->save();
            $sent++;
        }

        $this->sendAdminDigest($appointments, $target, $url);

        $this->info("Promemoria: {$sent} inviati, {$skipped} saltati (senza email). Appuntamenti: {$appointments->count()}.");

        return self::SUCCESS;
    }

    private static function clientDisplayName(?Client $client): string
    {
        if (! $client instanceof Client) {
            return 'Cliente';
        }

        $company = $client->getAttribute('company_name');
        if (is_string($company) && $company !== '') {
            return $company;
        }

        $name = $client->getAttribute('name');

        return is_string($name) && $name !== '' ? $name : 'Cliente';
    }

    /**
     * @param  Collection<int, Appointment>  $appointments
     */
    private function sendAdminDigest(Collection $appointments, Carbon $target, string $url): void
    {
        if ($this->option('dry-run')) {
            $this->line('DRY-RUN digest admin: '.$appointments->count().' appuntamenti il '.$target->format('d/m/Y'));

            return;
        }

        $lines = $appointments
            ->map(static function (Appointment $appointment): string {
                $client = $appointment->client;
                $name = $client instanceof Client ? self::clientDisplayName($client) : '—';
                $when = $appointment->getAttribute('date');

                return '- '.($when instanceof Carbon ? $when->format('H:i') : '—').' '.$name;
            })
            ->implode("\n");

        $notification = new GenericNotification(
            title: __('techplanner::appointment.reminder.admin_subject', ['date' => $target->format('d/m/Y')]),
            message: __('techplanner::appointment.reminder.admin_body', ['count' => $appointments->count()])."\n".$lines,
            channels: ['database', 'mail'],
            data: [
                'action_text' => __('techplanner::appointment.reminder.action_text'),
                'action_url' => $url,
            ],
        );

        User::role(['admin', 'super-admin'])->chunk(100, function (Collection $users) use ($notification): void {
            foreach ($users as $user) {
                $user->notify($notification);
            }
        });
    }
}
