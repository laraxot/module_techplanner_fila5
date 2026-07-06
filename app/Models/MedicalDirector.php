<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * Class MedicalDirector.
 *
 * @property int $id
 * @property string $name
 * @property string|null $license_number
 * @property string|null $specialization
 * @property string|null $phone
 * @property string|null $email
 * @property int|null $client_id
 * @property string|null $last_name
 * @property string|null $first_name
 * @property string|null $residence
 * @property string|null $address
 * @property string|null $street_number
 * @property string|null $province
 * @property string|null $birth_place
 * @property string|null $birth_date
 * @property string|null $start_date
 * @property string|null $end_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 *
 * @method static Builder<static>|MedicalDirector newModelQuery()
 * @method static Builder<static>|MedicalDirector newQuery()
 * @method static Builder<static>|MedicalDirector query()
 * @method static Builder<static>|MedicalDirector whereAddress($value)
 * @method static Builder<static>|MedicalDirector whereBirthDate($value)
 * @method static Builder<static>|MedicalDirector whereBirthPlace($value)
 * @method static Builder<static>|MedicalDirector whereClientId($value)
 * @method static Builder<static>|MedicalDirector whereCreatedAt($value)
 * @method static Builder<static>|MedicalDirector whereCreatedBy($value)
 * @method static Builder<static>|MedicalDirector whereDeletedAt($value)
 * @method static Builder<static>|MedicalDirector whereDeletedBy($value)
 * @method static Builder<static>|MedicalDirector whereEmail($value)
 * @method static Builder<static>|MedicalDirector whereEndDate($value)
 * @method static Builder<static>|MedicalDirector whereFirstName($value)
 * @method static Builder<static>|MedicalDirector whereId($value)
 * @method static Builder<static>|MedicalDirector whereLastName($value)
 * @method static Builder<static>|MedicalDirector whereLicenseNumber($value)
 * @method static Builder<static>|MedicalDirector whereName($value)
 * @method static Builder<static>|MedicalDirector wherePhone($value)
 * @method static Builder<static>|MedicalDirector whereProvince($value)
 * @method static Builder<static>|MedicalDirector whereResidence($value)
 * @method static Builder<static>|MedicalDirector whereSpecialization($value)
 * @method static Builder<static>|MedicalDirector whereStartDate($value)
 * @method static Builder<static>|MedicalDirector whereStreetNumber($value)
 * @method static Builder<static>|MedicalDirector whereUpdatedAt($value)
 * @method static Builder<static>|MedicalDirector whereUpdatedBy($value)
 * @method static Builder<static>|MedicalDirector selectRaw(string $expression)
 * @method static Builder<static>|MedicalDirector distinct()
 * @method static mixed pluck($column, $key = null)
 * @method static array<string, mixed> toArray()
 *
 * @property-read Profile|null $deleter
 *
 * @mixin \Eloquent
 */
class MedicalDirector extends BaseModel
{
    protected $fillable = [
        'client_id', // IDCliente
        'last_name', // Cognome
        'first_name', // Nome
        'residence', // Residenza
        'address', // Indirizzo
        'street_number', // N° civico
        'province', // Prov
        'birth_place', // nato a
        'birth_date', // Data nascita
        'start_date', // Data inizio
        'end_date', // Data fine
    ];
}
