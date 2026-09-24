<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Actions;

use Illuminate\Database\Eloquent\Collection;
use Modules\Geo\Actions\GetCoordinatesAction;
use Modules\TechPlanner\Models\Client;
use Spatie\QueueableAction\QueueableAction;

class UpdateAllClientCoordinatesAction
{
    use QueueableAction;

    public function __construct(
        private readonly GetCoordinatesAction $getCoordinatesAction,
    ) {}

    public function execute(): bool
    {
        /** @var Collection<int, Client> $clients */
        $clients = Client::whereNull('latitude')->orWhereNull('longitude')->get();

        foreach ($clients as $client) {
            // Usa l'azione per ottenere le coordinate dall'indirizzo
            $address = $client->full_address ?? null;
            if (is_string($address)) {
                $coordinates = $this->getCoordinatesAction->execute($address);

                if ($coordinates) {
                    $client->update([
                        'latitude' => $coordinates->latitude,
                        'longitude' => $coordinates->longitude,
                    ]);
                }
            }
        }

        return true;
    }
}
