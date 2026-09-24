<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Override;

/**
 * Class Device.
 *
 * @property-read Client|null $client
 * @property-read Profile|null $creator
 * @property-read DeviceVerification|null $latest_verification
 * @property-read bool $needs_verification
 * @property-read Profile|null $updater
 * @property-read Collection<int, DeviceVerification> $verifications
 * @property-read int|null $verifications_count
 *
 * @method static Builder<static>|Device newModelQuery()
 * @method static Builder<static>|Device newQuery()
 * @method static Builder<static>|Device query()
 *
 * @property int $id
 * @property int $appointment_id
 * @property string|null $name
 * @property string|null $status
 * @property string|null $notes
 * @property int|null $client_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property string|null $type
 * @property string|null $brand
 * @property string|null $model
 * @property string|null $headset_serial
 * @property string|null $tube_serial
 * @property numeric|null $kv
 * @property numeric|null $ma
 * @property string|null $serial_number
 * @property string|null $inventory_number
 * @property string|null $purchase_date
 * @property Carbon|null $first_verification_date
 * @property string|null $warranty_expiration
 *
 * @method static Builder<static>|Device whereAppointmentId($value)
 * @method static Builder<static>|Device whereBrand($value)
 * @method static Builder<static>|Device whereClientId($value)
 * @method static Builder<static>|Device whereCreatedAt($value)
 * @method static Builder<static>|Device whereCreatedBy($value)
 * @method static Builder<static>|Device whereDeletedAt($value)
 * @method static Builder<static>|Device whereDeletedBy($value)
 * @method static Builder<static>|Device whereFirstVerificationDate($value)
 * @method static Builder<static>|Device whereHeadsetSerial($value)
 * @method static Builder<static>|Device whereId($value)
 * @method static Builder<static>|Device whereInventoryNumber($value)
 * @method static Builder<static>|Device whereKv($value)
 * @method static Builder<static>|Device whereMa($value)
 * @method static Builder<static>|Device whereModel($value)
 * @method static Builder<static>|Device whereName($value)
 * @method static Builder<static>|Device whereNotes($value)
 * @method static Builder<static>|Device wherePurchaseDate($value)
 * @method static Builder<static>|Device whereSerialNumber($value)
 * @method static Builder<static>|Device whereStatus($value)
 * @method static Builder<static>|Device whereTubeSerial($value)
 * @method static Builder<static>|Device whereType($value)
 * @method static Builder<static>|Device whereUpdatedAt($value)
 * @method static Builder<static>|Device whereUpdatedBy($value)
 * @method static Builder<static>|Device whereWarrantyExpiration($value)
 *
 * @mixin \Eloquent
 */
class Device extends BaseModel
{
    protected $table = 'machines';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    #[Override]
    protected function casts(): array
    {
        return [
            'client_id' => 'integer',
            'first_verification_date' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    protected $fillable = [
        'id', // IDApparecchio
        'client_id', // IDCliente
        'type', // TipoApparecchio
        'brand', // Marca
        'model', // Modello
        'headset_serial', // Matricola Cuffia
        'tube_serial', // Matricola Tubo
        'kv', // KV
        'ma', // ma
        'first_verification_date', // DataPrimaVerifica
        'notes', // Commenti
    ];

    /**
     * Get the client that owns the device.
     *
     * @return BelongsTo<Client, $this>
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get all verifications for this device.
     *
     * @return HasMany<DeviceVerification, $this>
     */
    public function verifications(): HasMany
    {
        return $this->hasMany(DeviceVerification::class);
    }

    /**
     * Get the latest verification for this device.
     */
    public function getLatestVerificationAttribute(): ?DeviceVerification
    {
        return ($this->verifications()->latest()->first() instanceof DeviceVerification)
            ? $this->verifications()->latest()->first()
            : null;
    }

    /**
     * Check if the device needs verification.
     */
    public function getNeedsVerificationAttribute(): bool
    {
        if (! $this->latest_verification) {
            return true;
        }

        // Verifica se la data di prossima verifica è passata
        $nextVerificationDate = $this->latest_verification->getAttribute('next_verification_date');
        if (! $nextVerificationDate) {
            return true;
        }

        return $nextVerificationDate <= now();
    }
}
