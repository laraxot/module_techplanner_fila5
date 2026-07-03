<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Override;

/**
 * @property int $id
 * @property int $client_id
 * @property Carbon $date
 * @property int|null $duration
 * @property string|null $notes
 * @property string $call_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 *
 * @method static Builder<static>|PhoneCall newModelQuery()
 * @method static Builder<static>|PhoneCall newQuery()
 * @method static Builder<static>|PhoneCall query()
 * @method static Builder<static>|PhoneCall whereCallType($value)
 * @method static Builder<static>|PhoneCall whereClientId($value)
 * @method static Builder<static>|PhoneCall whereCreatedAt($value)
 * @method static Builder<static>|PhoneCall whereCreatedBy($value)
 * @method static Builder<static>|PhoneCall whereDate($value)
 * @method static Builder<static>|PhoneCall whereDeletedAt($value)
 * @method static Builder<static>|PhoneCall whereDeletedBy($value)
 * @method static Builder<static>|PhoneCall whereDuration($value)
 * @method static Builder<static>|PhoneCall whereId($value)
 * @method static Builder<static>|PhoneCall whereNotes($value)
 * @method static Builder<static>|PhoneCall whereUpdatedAt($value)
 * @method static Builder<static>|PhoneCall whereUpdatedBy($value)
 *
 * @property-read Profile|null $deleter
 *
 * @mixin \Eloquent
 */
class PhoneCall extends BaseModel
{
    protected $fillable = [
        'client_id',
        'date',
        'duration',
        'notes',
        'call_type',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    #[Override]
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'date' => 'datetime',
        ]);
    }
}
