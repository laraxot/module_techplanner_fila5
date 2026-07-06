<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $client_id
 * @property string $date
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
        'date',
        'notes',
    ];

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
     * Relazione con le macchine controllate.
     *
     * @return HasMany<Machine, $this>
     */
    public function machines(): HasMany
    {
        return $this->hasMany(Machine::class);
    }
}
