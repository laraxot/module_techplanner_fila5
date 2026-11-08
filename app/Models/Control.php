<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Modules\TechPlanner\Enums\ControlTypeEnum;
use Parental\HasChildren;

/**
 * Controllo tecnico eseguito su un cliente (studio dentistico, veterinaria, ecc.).
 *
 * Single-table inheritance via tightenco/parental: la colonna discriminante
 * `control_type` decide quale modello figlio idrata (RxControl, IntraoralControl,
 * HealthAuthorizationControl, ElectromedicalControl, OtherControl). La tabella
 * `controls` è condivisa.
 */
class Control extends BaseModel
{
    use HasChildren;
    use SoftDeletes;

    /** @var string */
    protected $table = 'controls';

    /** @var string */
    protected $childColumn = 'control_type';

    /** @var array<string, class-string<Control>> */
    protected $childTypes = [
        ControlTypeEnum::RX->value => RxControl::class,
        ControlTypeEnum::INTRAORAL->value => IntraoralControl::class,
        ControlTypeEnum::HEALTH_AUTHORIZATION->value => HealthAuthorizationControl::class,
        ControlTypeEnum::ELECTROMEDICAL->value => ElectromedicalControl::class,
        ControlTypeEnum::OTHER->value => OtherControl::class,
    ];

    protected static function booted(): void
    {
        // PM engine minimale: se il controllo ha una data e nessuna prossima
        // scadenza dichiarata, la prossima viene derivata dalla cadenza del
        // tipo (12 mesi per i controlli normati). Una cancellazione esplicita
        // di `next_control_date` non viene sovrascritta.
        static::saving(static function (Control $control): void {
            $nextControlDate = $control->getAttribute('next_control_date');

            if ($control->isDirty('next_control_date') || $nextControlDate !== null) {
                return;
            }

            $controlType = $control->getAttribute('control_type');
            $months = $controlType instanceof ControlTypeEnum
                ? $controlType->defaultRecurrenceMonths()
                : null;
            $controlDate = $control->getAttribute('control_date');

            if ($months === null || ! $controlDate instanceof Carbon) {
                return;
            }

            $control->setAttribute('next_control_date', $controlDate->copy()->addMonths($months));
        });
    }

    /** @var list<string> */
    protected $fillable = [
        'client_id',
        'device_id',
        'worker_id',
        'appointment_id',
        'control_type',
        'status',
        'result',
        'control_date',
        'next_control_date',
        'notes',
        'metadata',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'control_type' => ControlTypeEnum::class,
            'control_date' => 'date',
            'next_control_date' => 'date',
            'metadata' => 'array',
        ];
    }

    /** @return BelongsTo<Client, $this> */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /** @return BelongsTo<Device, $this> */
    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class, 'device_id');
    }

    /** @return BelongsTo<Worker, $this> */
    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class, 'worker_id');
    }

    /** @return BelongsTo<Appointment, $this> */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}
