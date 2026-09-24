<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property-read Appointment|null $appointment
 * @property-read Client|null $client
 * @property-read Profile|null $creator
 * @property-read DeviceVerification|null $latest_verification
 * @property-read bool $needs_verification
 * @property-read Profile|null $updater
 * @property-read Collection<int, DeviceVerification> $verifications
 * @property-read int|null $verifications_count
 *
 * @method static Builder<static>|Machine newModelQuery()
 * @method static Builder<static>|Machine newQuery()
 * @method static Builder<static>|Machine query()
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
 * @method static Builder<static>|Machine whereAppointmentId($value)
 * @method static Builder<static>|Machine whereBrand($value)
 * @method static Builder<static>|Machine whereClientId($value)
 * @method static Builder<static>|Machine whereCreatedAt($value)
 * @method static Builder<static>|Machine whereCreatedBy($value)
 * @method static Builder<static>|Machine whereDeletedAt($value)
 * @method static Builder<static>|Machine whereDeletedBy($value)
 * @method static Builder<static>|Machine whereFirstVerificationDate($value)
 * @method static Builder<static>|Machine whereHeadsetSerial($value)
 * @method static Builder<static>|Machine whereId($value)
 * @method static Builder<static>|Machine whereInventoryNumber($value)
 * @method static Builder<static>|Machine whereKv($value)
 * @method static Builder<static>|Machine whereMa($value)
 * @method static Builder<static>|Machine whereModel($value)
 * @method static Builder<static>|Machine whereName($value)
 * @method static Builder<static>|Machine whereNotes($value)
 * @method static Builder<static>|Machine wherePurchaseDate($value)
 * @method static Builder<static>|Machine whereSerialNumber($value)
 * @method static Builder<static>|Machine whereStatus($value)
 * @method static Builder<static>|Machine whereTubeSerial($value)
 * @method static Builder<static>|Machine whereType($value)
 * @method static Builder<static>|Machine whereUpdatedAt($value)
 * @method static Builder<static>|Machine whereUpdatedBy($value)
 * @method static Builder<static>|Machine whereWarrantyExpiration($value)
 *
 * @mixin \Eloquent
 */
class Machine extends Device
{
    /**
     * Relazione con l appuntamento.
     *
     * @return BelongsTo<Appointment, $this>
     */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}
