<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * Class LegalOffice.
 *
 * @property int $id
 * @property string $name
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $email
 * @property int $client_id
 * @property string|null $city
 * @property string|null $postal_code
 * @property string|null $province
 * @property string|null $country
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 *
 * @method static Builder<static>|LegalOffice newModelQuery()
 * @method static Builder<static>|LegalOffice newQuery()
 * @method static Builder<static>|LegalOffice query()
 * @method static Builder<static>|LegalOffice whereAddress($value)
 * @method static Builder<static>|LegalOffice whereCity($value)
 * @method static Builder<static>|LegalOffice whereClientId($value)
 * @method static Builder<static>|LegalOffice whereCountry($value)
 * @method static Builder<static>|LegalOffice whereCreatedAt($value)
 * @method static Builder<static>|LegalOffice whereCreatedBy($value)
 * @method static Builder<static>|LegalOffice whereDeletedAt($value)
 * @method static Builder<static>|LegalOffice whereDeletedBy($value)
 * @method static Builder<static>|LegalOffice whereEmail($value)
 * @method static Builder<static>|LegalOffice whereId($value)
 * @method static Builder<static>|LegalOffice wherePhone($value)
 * @method static Builder<static>|LegalOffice wherePostalCode($value)
 * @method static Builder<static>|LegalOffice whereProvince($value)
 * @method static Builder<static>|LegalOffice whereUpdatedAt($value)
 * @method static Builder<static>|LegalOffice whereUpdatedBy($value)
 *
 * @property-read Profile|null $deleter
 *
 * @mixin \Eloquent
 */
class LegalOffice extends BaseModel
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
    ];
}
