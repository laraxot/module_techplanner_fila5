<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Geo\Models\Traits\GeoTrait;
// --- traits ---
use Modules\TechPlanner\Contracts\WorkerContract;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Override;

/**
 * Modules\TechPlanner\Models\Worker.
 *
 * @property mixed $address
 * @property string $full_address
 * @property float|null $latitude
 * @property float|null $longitude
 * @property int $id
 * @property string|null $type
 * @property int|null $client_id
 * @property string|null $last_name
 * @property string|null $first_name
 * @property string|null $birth_place
 * @property string|null $birth_day
 * @property string|null $date_start
 * @property string|null $date_end
 * @property string|null $note
 * @property string|null $premise
 * @property string|null $premise_short
 * @property string|null $locality
 * @property string|null $locality_short
 * @property string|null $postal_town
 * @property string|null $postal_town_short
 * @property string|null $administrative_area_level_3
 * @property string|null $administrative_area_level_3_short
 * @property string|null $administrative_area_level_2
 * @property string|null $administrative_area_level_2_short
 * @property string|null $administrative_area_level_1
 * @property string|null $administrative_area_level_1_short
 * @property string|null $country
 * @property string|null $country_short
 * @property string|null $street_number
 * @property string|null $street_number_short
 * @property string|null $route
 * @property string|null $route_short
 * @property string|null $postal_code
 * @property string|null $postal_code_short
 * @property string|null $point_of_interest
 * @property string|null $point_of_interest_short
 * @property string|null $political
 * @property string|null $political_short
 * @property string|null $phone
 * @property string|null $website
 * @property string|null $email
 * @property string|null $formatted_address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string $full_name
 * @property string|null $p_iva
 * @property string|null $cod_fisc
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @property-read Profile|null $creator
 * @property-read Collection<int, Device> $devices
 * @property-read int|null $devices_count
 * @property-read Profile|null $updater
 *
 * @method static Builder<static>|Worker newModelQuery()
 * @method static Builder<static>|Worker newQuery()
 * @method static Builder<static>|Worker ofInPolygon(string $polygon_field, float $lat, float $lng)
 * @method static Builder<static>|Worker ofJobRoleId(int $id)
 * @method static Builder<static>|Worker query()
 * @method static Builder<static>|Worker whereAddress($value)
 * @method static Builder<static>|Worker whereAdministrativeAreaLevel1($value)
 * @method static Builder<static>|Worker whereAdministrativeAreaLevel1Short($value)
 * @method static Builder<static>|Worker whereAdministrativeAreaLevel2($value)
 * @method static Builder<static>|Worker whereAdministrativeAreaLevel2Short($value)
 * @method static Builder<static>|Worker whereAdministrativeAreaLevel3($value)
 * @method static Builder<static>|Worker whereAdministrativeAreaLevel3Short($value)
 * @method static Builder<static>|Worker whereBirthDay($value)
 * @method static Builder<static>|Worker whereBirthPlace($value)
 * @method static Builder<static>|Worker whereClientId($value)
 * @method static Builder<static>|Worker whereCodFisc($value)
 * @method static Builder<static>|Worker whereCountry($value)
 * @method static Builder<static>|Worker whereCountryShort($value)
 * @method static Builder<static>|Worker whereCreatedAt($value)
 * @method static Builder<static>|Worker whereCreatedBy($value)
 * @method static Builder<static>|Worker whereDateEnd($value)
 * @method static Builder<static>|Worker whereDateStart($value)
 * @method static Builder<static>|Worker whereDeletedAt($value)
 * @method static Builder<static>|Worker whereDeletedBy($value)
 * @method static Builder<static>|Worker whereEmail($value)
 * @method static Builder<static>|Worker whereFirstName($value)
 * @method static Builder<static>|Worker whereFormattedAddress($value)
 * @method static Builder<static>|Worker whereFullAddress($value)
 * @method static Builder<static>|Worker whereFullName($value)
 * @method static Builder<static>|Worker whereId($value)
 * @method static Builder<static>|Worker whereLastName($value)
 * @method static Builder<static>|Worker whereLatitude($value)
 * @method static Builder<static>|Worker whereLocality($value)
 * @method static Builder<static>|Worker whereLocalityShort($value)
 * @method static Builder<static>|Worker whereLongitude($value)
 * @method static Builder<static>|Worker whereNote($value)
 * @method static Builder<static>|Worker wherePIva($value)
 * @method static Builder<static>|Worker wherePhone($value)
 * @method static Builder<static>|Worker wherePointOfInterest($value)
 * @method static Builder<static>|Worker wherePointOfInterestShort($value)
 * @method static Builder<static>|Worker wherePolitical($value)
 * @method static Builder<static>|Worker wherePoliticalShort($value)
 * @method static Builder<static>|Worker wherePostalCode($value)
 * @method static Builder<static>|Worker wherePostalCodeShort($value)
 * @method static Builder<static>|Worker wherePostalTown($value)
 * @method static Builder<static>|Worker wherePostalTownShort($value)
 * @method static Builder<static>|Worker wherePremise($value)
 * @method static Builder<static>|Worker wherePremiseShort($value)
 * @method static Builder<static>|Worker whereRoute($value)
 * @method static Builder<static>|Worker whereRouteShort($value)
 * @method static Builder<static>|Worker whereStreetNumber($value)
 * @method static Builder<static>|Worker whereStreetNumberShort($value)
 * @method static Builder<static>|Worker whereType($value)
 * @method static Builder<static>|Worker whereUpdatedAt($value)
 * @method static Builder<static>|Worker whereUpdatedBy($value)
 * @method static Builder<static>|Worker whereWebsite($value)
 * @method static Builder<static>|Worker withDistance(float $lat, float $lng)
 * @method static Builder<static>|Worker withDistanceCustomField(string $lat_field, string $lng_field, float $lat, float $lng)
 *
 * @property string|null $googleplace_url
 * @property string|null $googleplace_url_short
 * @property string|null $campground
 * @property string|null $campground_short
 * @property-read Profile|null $deleter
 *
 * @method static Builder<static>|Worker whereCampground($value)
 * @method static Builder<static>|Worker whereCampgroundShort($value)
 * @method static Builder<static>|Worker whereGoogleplaceUrl($value)
 * @method static Builder<static>|Worker whereGoogleplaceUrlShort($value)
 *
 * @mixin \Eloquent
 */
class Worker extends BaseModel implements WorkerContract
{
    use GeoTrait;

    // protected $connection = 'customer'; // this will use the specified database conneciton

    /** @var list<string> */
    protected $fillable = [
        'id',
        'type',
        'first_name',
        'last_name',
        'full_name',
        'address',
        'full_address',
        'note',
        'birth_day',
        'birth_place',
        'cod_fisc',
        'p_iva',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    #[Override]
    protected function casts(): array
    {
        return [
            'address' => 'array',
        ];
    }

    // ---------------- relationships ----------------

    /**
     * Get devices associated with this worker.
     */
    public function devices(): HasMany
    {
        return $this->hasMany(Device::class); // ,customer_id,id
    }

    // ---------------- mutators --------------------------

    public function setBirthDayAttribute(string|Carbon|null $value): void
    {
        try {
            if ($value instanceof Carbon) {
                $this->attributes['birth_day'] = $value;

                return;
            }
            $valueString = $this->safeStringCast($value);
            if ($valueString !== '') {
                $this->attributes['birth_day'] = Carbon::createFromFormat('d/m/Y', $valueString);
            }
        } catch (Exception $e) {
            // Ignore invalid date formats
        }
    }

    public function getFullNameAttribute(string|int|float|bool|null $value): string
    {
        if ($value !== null && $value !== '') {
            return $this->safeStringCast($value);
        }
        $type = $this->getAttribute('type');
        $lastName = $this->getAttribute('last_name');
        $firstName = $this->getAttribute('first_name');

        // Safe string casting for all components
        $typeStr = $this->safeStringCast(is_scalar($type) || $type === null ? $type : '');
        $lastNameStr = $this->safeStringCast(is_scalar($lastName) || $lastName === null ? $lastName : '');
        $firstNameStr = $this->safeStringCast(is_scalar($firstName) || $firstName === null ? $firstName : '');

        $computed = trim($typeStr.' '.$lastNameStr.' '.$firstNameStr);

        return $computed;
    }

    /**
     * Converte in modo sicuro un valore in string usando l'action centralizzata.
     *
     * @param  string|int|float|bool|null|mixed  $value  Il valore da convertire
     * @return string Il valore convertito in string
     */
    private function safeStringCast(mixed $value): string
    {
        return app(SafeStringCastAction::class)->execute($value);
    }

    // ------------------- scopes ------------------------

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeOfJobRoleId(Builder $query, int $id): Builder
    {
        // TODO: Implement jobRoles relation before using this scope
        return $query->where('id', '>', 0); // Temporary placeholder

        /*
         * return $query->whereHas(
         * 'jobRoles', function (Builder $query) use ($id): void {
         * $query->where('job_role_id', $id);
         * }
         * );
         */
    }

    public function getCodFiscAttribute(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }
        $value = str_replace(' ', '', $value);
        $value = trim($value);
        $nome = substr($value, 0, 3);
        $cognome = substr($value, 3, 3);
        $data = substr($value, 6, 5);
        $citta = substr($value, 11, 4);
        $crc = substr($value, 15, 1);

        return $nome.' '.$cognome.' '.$data.' '.$citta.' '.$crc;
    }
}
