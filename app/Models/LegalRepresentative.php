<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class LegalRepresentative.
 *
 * @property int $id
 * @property string $name
 * @property string|null $identification_number
 * @property string|null $phone
 * @property string|null $email
 * @property int $client_id
 * @property string|null $fiscal_code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @property-read Client $client
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 *
 * @method static Builder<static>|LegalRepresentative newModelQuery()
 * @method static Builder<static>|LegalRepresentative newQuery()
 * @method static Builder<static>|LegalRepresentative query()
 * @method static Builder<static>|LegalRepresentative whereClientId($value)
 * @method static Builder<static>|LegalRepresentative whereCreatedAt($value)
 * @method static Builder<static>|LegalRepresentative whereCreatedBy($value)
 * @method static Builder<static>|LegalRepresentative whereDeletedAt($value)
 * @method static Builder<static>|LegalRepresentative whereDeletedBy($value)
 * @method static Builder<static>|LegalRepresentative whereEmail($value)
 * @method static Builder<static>|LegalRepresentative whereFiscalCode($value)
 * @method static Builder<static>|LegalRepresentative whereId($value)
 * @method static Builder<static>|LegalRepresentative whereName($value)
 * @method static Builder<static>|LegalRepresentative wherePhone($value)
 * @method static Builder<static>|LegalRepresentative whereUpdatedAt($value)
 * @method static Builder<static>|LegalRepresentative whereUpdatedBy($value)
 *
 * @property-read Profile|null $deleter
 *
 * @mixin \Eloquent
 */
class LegalRepresentative extends BaseModel
{
    protected $fillable = [
        'name',
        'identification_number',
        'phone',
        'email',
    ];

    /**
     * Get the client that owns the legal representative.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
