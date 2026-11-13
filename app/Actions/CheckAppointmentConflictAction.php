<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Actions;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\TechPlanner\Enums\AppointmentStatusEnum;
use Modules\TechPlanner\Models\Appointment;
use Spatie\QueueableAction\QueueableAction;

/**
 * Verifica se un tecnico ha già un appuntamento attivo nella fascia oraria data.
 *
 * Un appuntamento "attivo" è uno la cui status non è terminale
 * (completed, cancelled, no_show): quelli non occupano più la agenda.
 * L'intervallo è [start, start + durationMinutes).
 */
class CheckAppointmentConflictAction
{
    use QueueableAction;

    /**
     * @return Appointment|null Il primo appuntamento in conflitto, null se la fascia è libera.
     */
    public function execute(
        int $workerId,
        Carbon $start,
        int $durationMinutes = 60,
        ?int $excludeAppointmentId = null,
    ): ?Appointment {
        if ($workerId <= 0 || $durationMinutes <= 0) {
            return null;
        }

        $end = $start->copy()->addMinutes($durationMinutes);

        $candidates = Appointment::query()
            ->where('worker_id', $workerId)
            ->whereNotIn('status', [
                AppointmentStatusEnum::COMPLETED->value,
                AppointmentStatusEnum::CANCELLED->value,
                AppointmentStatusEnum::NO_SHOW->value,
            ])
            ->when(
                $excludeAppointmentId !== null,
                static fn (Builder $query): Builder => $query->whereKeyNot($excludeAppointmentId),
            )
            ->where('date', '<', $end)
            ->orderBy('date')
            ->get();

        /** @var Appointment|null */
        return $candidates->first(
            static fn (Appointment $appointment): bool => $appointment->endAt()->gt($start),
        );
    }
}
