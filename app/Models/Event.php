<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\TechPlanner\Database\Factories\EventFactory;

/**
 * @method static \Modules\TechPlanner\Database\Factories\EventFactory factory($count = null, $state = [])
 * @method static Builder<static>|Event newModelQuery()
 * @method static Builder<static>|Event newQuery()
 * @method static Builder<static>|Event query()
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $start_at
 * @property string $end_at
 * @property string|null $status
 *
 * @method static Builder<static>|Event whereDescription($value)
 * @method static Builder<static>|Event whereEndAt($value)
 * @method static Builder<static>|Event whereId($value)
 * @method static Builder<static>|Event whereName($value)
 * @method static Builder<static>|Event whereStartAt($value)
 * @method static Builder<static>|Event whereStatus($value)
 *
 * @mixin \Eloquent
 */
class Event extends Model
{
    /** @use HasFactory<EventFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ]);
    }

    protected static function newFactory(): EventFactory
    {
        return EventFactory::new();
    }
}
