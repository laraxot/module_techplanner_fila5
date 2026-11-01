<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Actions\Contact;

use Modules\TechPlanner\Datas\ContactMessageData;
use Modules\TechPlanner\Enums\ContactMessageStatusEnum;
use Modules\TechPlanner\Models\ContactMessage;

/**
 * Archivia il messaggio (stato Pending) con l'istante di accettazione dell'informativa. Lancia se il database rifiuta.
 */
class StoreContactMessageAction
{
    public function execute(ContactMessageData $data, string $locale): ContactMessage
    {
        return ContactMessage::query()->create([
            'name' => $data->name,
            'email' => $data->email,
            'phone' => $data->phone,
            'studio' => $data->studio,
            'type' => $data->type,
            'message' => $data->message,
            'locale' => $locale,
            'status' => ContactMessageStatusEnum::Pending,
            'privacy_accepted_at' => now(),
        ]);
    }
}
