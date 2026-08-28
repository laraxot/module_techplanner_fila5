<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * Class DeviceVerification.
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 *
 * @method static Builder<static>|DeviceVerification newModelQuery()
 * @method static Builder<static>|DeviceVerification newQuery()
 * @method static Builder<static>|DeviceVerification query()
 *
 * @property int $id
 * @property int $device_id
 * @property string $verification_date
 * @property string $next_verification_date
 * @property string $result
 * @property string $exposure_parameters
 * @property string $verification_type
 * @property string|null $notes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 *
 * @method static Builder<static>|DeviceVerification whereCreatedAt($value)
 * @method static Builder<static>|DeviceVerification whereCreatedBy($value)
 * @method static Builder<static>|DeviceVerification whereDeletedAt($value)
 * @method static Builder<static>|DeviceVerification whereDeletedBy($value)
 * @method static Builder<static>|DeviceVerification whereDeviceId($value)
 * @method static Builder<static>|DeviceVerification whereExposureParameters($value)
 * @method static Builder<static>|DeviceVerification whereId($value)
 * @method static Builder<static>|DeviceVerification whereNextVerificationDate($value)
 * @method static Builder<static>|DeviceVerification whereNotes($value)
 * @method static Builder<static>|DeviceVerification whereResult($value)
 * @method static Builder<static>|DeviceVerification whereUpdatedAt($value)
 * @method static Builder<static>|DeviceVerification whereUpdatedBy($value)
 * @method static Builder<static>|DeviceVerification whereVerificationDate($value)
 * @method static Builder<static>|DeviceVerification whereVerificationType($value)
 *
 * @mixin \Eloquent
 */
class DeviceVerification extends BaseModel
{
    protected $fillable = [
        'device_id',
        'verification_date',
        'status',
    ];
}
