<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Actions\Contact;

use Illuminate\Support\Facades\Log;
use Modules\TechPlanner\Datas\ContactMessageData;
use Modules\TechPlanner\Enums\ContactMessageStatusEnum;
use Modules\TechPlanner\Enums\ContactOutcomeEnum;
use Modules\TechPlanner\Models\ContactMessage;

/**
 * Archivia e poi inoltra: l'archivio viene prima, cosi' un guasto del trasporto e-mail non perde il messaggio.
 * Esito: Sent se l'inoltro e' riuscito (anche se l'archivio e' fallito: la mail e' arrivata), Received se archiviato ma
 * non inoltrato, Failed se non e' riuscito nulla. Nei log solo la classe dell'eccezione: mai dati del mittente.
 */
final class DeliverContactMessageAction
{
    public function __construct(
        private readonly ResolveContactRecipientAction $resolveRecipient,
        private readonly StoreContactMessageAction $store,
        private readonly SendContactMessageAction $send,
        private readonly UpdateContactMessageStatusAction $updateStatus,
    ) {}

    public function execute(ContactMessageData $data, string $locale): ContactOutcomeEnum
    {
        $record = $this->archive($data, $locale);
        $recipient = $this->resolveRecipient->execute();

        $forwarded = false;
        if ($recipient !== null) {
            $forwarded = $this->forward($data, $recipient, $locale);
        }

        if ($record !== null) {
            $this->recordStatus($record, match (true) {
                $forwarded => ContactMessageStatusEnum::Forwarded,
                $recipient === null => ContactMessageStatusEnum::Pending,
                default => ContactMessageStatusEnum::ForwardFailed,
            });
        }

        return match (true) {
            $forwarded => ContactOutcomeEnum::Sent,
            $record !== null => ContactOutcomeEnum::Received,
            default => ContactOutcomeEnum::Failed,
        };
    }

    private function archive(ContactMessageData $data, string $locale): ?ContactMessage
    {
        try {
            return $this->store->execute($data, $locale);
        } catch (\Throwable $e) {
            Log::error('Contact form archive failed', ['exception' => $e::class]);

            return null;
        }
    }

    private function forward(ContactMessageData $data, string $recipient, string $locale): bool
    {
        try {
            $this->send->execute($data, $recipient, $locale);

            return true;
        } catch (\Throwable $e) {
            Log::error('Contact form delivery failed', ['exception' => $e::class]);

            return false;
        }
    }

    private function recordStatus(ContactMessage $record, ContactMessageStatusEnum $status): void
    {
        if ($status === ContactMessageStatusEnum::Pending) {
            return;
        }

        try {
            $this->updateStatus->execute($record, $status);
        } catch (\Throwable $e) {
            Log::error('Contact form status update failed', ['exception' => $e::class]);
        }
    }
}
