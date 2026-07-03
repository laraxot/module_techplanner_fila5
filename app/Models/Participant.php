<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\TechPlanner\Database\Factories\ParticipantFactoryFactory;

/**
 * @method static ParticipantFactoryFactory factory($count = null, $state = [])
 * @method static Builder<static>|Participant newModelQuery()
 * @method static Builder<static>|Participant newQuery()
 * @method static Builder<static>|Participant query()
 *
 * @mixin \Eloquent
 */
class Participant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    protected static function newFactory(): ParticipantFactoryFactory
    {
        return ParticipantFactoryFactory::new();
    }
}
