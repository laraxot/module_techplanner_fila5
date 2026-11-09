<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Modules\TechPlanner\Enums\AppointmentStatusEnum;

/**
 * @property int $id
 * @property int $client_id
 * @property int|null $worker_id
 * @property Carbon|null $date
 * @property int $duration_minutes
 * @property string|null $status
 * @property string|null $notes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @property-read Client $client
 * @property-read Collection<int, Machine> $machines
 * @property-read int|null $machines_count
 *
 * @method static Builder<static>|Appointment newModelQuery()
 * @method static Builder<static>|Appointment newQuery()
 * @method static Builder<static>|Appointment query()
 * @method static Builder<static>|Appointment whereClientId($value)
 * @method static Builder<static>|Appointment whereCreatedAt($value)
 * @method static Builder<static>|Appointment whereCreatedBy($value)
 * @method static Builder<static>|Appointment whereDate($value)
 * @method static Builder<static>|Appointment whereDeletedAt($value)
 * @method static Builder<static>|Appointment whereDeletedBy($value)
 * @method static Builder<static>|Appointment whereId($value)
 * @method static Builder<static>|Appointment whereNotes($value)
 * @method static Builder<static>|Appointment whereUpdatedAt($value)
 * @method static Builder<static>|Appointment whereUpdatedBy($value)
 *
 * @mixin \Eloquent
 */
class Appointment extends Model
{
    protected $fillable = [
        'client_id',
        'worker_id',
        'date',
        'duration_minutes',
        'status',
        'outcome',
        'reminder_sent_at',
        'notes',
    ];

    /**
     * Istante di fine dell'appuntamento (date + duration_minutes).
     */
    public function endAt(): Carbon
    {
        $start = $this->date ?? Carbon::now();

        return $start->copy()->addMinutes($this->duration_minutes);
    }

    /**
     * Relazione con il cliente.
     *
     * @return BelongsTo<Client, $this>
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Relazione con il tecnico assegnato.
     *
     * @return BelongsTo<Worker, $this>
     */
    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }

    /**
     * Relazione con le macchine controllate.
     *
     * @return HasMany<Machine, $this>
     */
    public function machines(): HasMany
    {
        return $this->hasMany(Machine::class);
    }

    /**
     * Controlli eseguiti in questo appuntamento: il `control_type`
     * (rx, elettromedicali, ...) dice per cosa era l'intervento.
     *
     * @return HasMany<Control, $this>
     */
    public function controls(): HasMany
    {
        return $this->hasMany(Control::class);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'status' => AppointmentStatusEnum::class,
            'date' => 'datetime',
            'duration_minutes' => 'integer',
            'reminder_sent_at' => 'datetime',
        ]);
    }
}
