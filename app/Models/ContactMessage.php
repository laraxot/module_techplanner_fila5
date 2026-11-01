<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Modules\TechPlanner\Database\Factories\ContactMessageFactory;
use Modules\TechPlanner\Enums\ContactMessageStatusEnum;
use Override;

/**
 * Messaggio ricevuto dal form di contatto del sito. Solo i campi che servono a rispondere, la lingua della pagina e
 * il momento in cui il mittente ha accettato l'informativa. Niente IP ne' user agent.
 * Nessuna cancellazione automatica finche' `techplanner.contact.retention_days` e' vuoto (periodo DA CONFERMARE).
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $studio
 * @property string|null $type
 * @property string $message
 * @property string $locale
 * @property ContactMessageStatusEnum $status
 * @property Carbon $privacy_accepted_at
 * @property Carbon|null $forwarded_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class ContactMessage extends BaseModel
{
    /** @use HasFactory<ContactMessageFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'studio',
        'type',
        'message',
        'locale',
        'status',
        'privacy_accepted_at',
        'forwarded_at',
    ];

    protected static function newFactory(): ContactMessageFactory
    {
        return ContactMessageFactory::new();
    }

    /**
     * @return array<string, string>
     */
    #[Override]
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'status' => ContactMessageStatusEnum::class,
            'privacy_accepted_at' => 'datetime',
            'forwarded_at' => 'datetime',
        ]);
    }
}
