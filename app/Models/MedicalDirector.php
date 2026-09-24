<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * Class MedicalDirector.
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 *
 * @method static Builder<static>|MedicalDirector newModelQuery()
 * @method static Builder<static>|MedicalDirector newQuery()
 * @method static Builder<static>|MedicalDirector query()
 *
 * @property int $id
 * @property int $client_id
 * @property string $name
 * @property string|null $fiscal_code
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $notes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 *
 * @method static Builder<static>|MedicalDirector whereClientId($value)
 * @method static Builder<static>|MedicalDirector whereCreatedAt($value)
 * @method static Builder<static>|MedicalDirector whereCreatedBy($value)
 * @method static Builder<static>|MedicalDirector whereDeletedAt($value)
 * @method static Builder<static>|MedicalDirector whereDeletedBy($value)
 * @method static Builder<static>|MedicalDirector whereEmail($value)
 * @method static Builder<static>|MedicalDirector whereFiscalCode($value)
 * @method static Builder<static>|MedicalDirector whereId($value)
 * @method static Builder<static>|MedicalDirector whereName($value)
 * @method static Builder<static>|MedicalDirector whereNotes($value)
 * @method static Builder<static>|MedicalDirector wherePhone($value)
 * @method static Builder<static>|MedicalDirector whereUpdatedAt($value)
 * @method static Builder<static>|MedicalDirector whereUpdatedBy($value)
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
