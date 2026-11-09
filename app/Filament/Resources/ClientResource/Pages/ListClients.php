<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ClientResource\Pages;

use Exception;
use Filament\Actions\Action;
use Filament\Actions\ImportAction;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;
use Modules\Geo\Actions\UpdateCoordinatesFromAddressAction;
use Modules\TechPlanner\Filament\Imports\ClientImporter;
use Modules\TechPlanner\Filament\Resources\ClientResource;
use Modules\TechPlanner\Filament\Widgets\ClientMapWidget;
use Modules\TechPlanner\Filament\Widgets\CoordinatesWidget;
use Modules\TechPlanner\Models\Client;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

/**
 * @property ClientResource $resource
 */
class ListClients extends XotBaseListRecords
{
    protected static string $resource = ClientResource::class;

    public ?int $selectedClientId = null;

    /** @var Builder<Client>|null */
    protected ?Builder $tableQuery = null;

    /**
     * Configura i widget dell'header della pagina.
     */
    protected function getHeaderWidgets(): array
    {
        return [
            CoordinatesWidget::class,
            ClientMapWidget::class,
        ];
    }

    #[On('set-client-distance-origin')]
    public function setDistanceOrigin(int $clientId): void
    {
        $client = Client::query()->find($clientId);

        if (! $client instanceof Client) {
            $this->notifyOriginMissing();

            return;
        }

        $latitude = $client->getAttribute('latitude');
        $longitude = $client->getAttribute('longitude');

        if (! is_numeric($latitude) || ! is_numeric($longitude)) {
            app(UpdateCoordinatesFromAddressAction::class)->execute($client);
            $client->refresh();
            $latitude = $client->getAttribute('latitude');
            $longitude = $client->getAttribute('longitude');
        }

        if (! is_numeric($latitude) || ! is_numeric($longitude)) {
            $this->notifyOriginMissing(__('techplanner::client_map_widget.origin_missing_geocode_failed.body'));

            return;
        }

        Session::put('user_latitude', (float) $latitude);
        Session::put('user_longitude', (float) $longitude);
        Cookie::queue('user_latitude', (string) $latitude, 60 * 24 * 30);
        Cookie::queue('user_longitude', (string) $longitude, 60 * 24 * 30);
        $this->resetTable();

        Notification::make()
            ->success()
            ->title(__('techplanner::client_map_widget.origin_set.title'))
            ->body(__('techplanner::client_map_widget.origin_set.body'))
            ->send();
    }

    private function notifyOriginMissing(?string $body = null): void
    {
        Notification::make()
            ->warning()
            ->title(__('techplanner::client_map_widget.origin_missing.title'))
            ->body($body ?? __('techplanner::client_map_widget.origin_missing.body'))
            ->send();
    }

    #[Override]
    public function getHeaderActions(): array
    {
        /** @var array<string, Action> $actions */
        $actions = [
            ...parent::getHeaderActions(),
            ImportAction::make('importClient')->importer(ClientImporter::class),
            Action::make('populateCoordinates')
                ->icon('heroicon-o-globe-alt')
                ->label(__('techplanner::client.actions.populateCoordinates.label'))
                ->action(function () {
                    $this->populateAllCoordinates();
                })
                ->requiresConfirmation()
                ->modalHeading(trans('techplanner::client.actions.populateCoordinates.modal.heading'))
                ->modalDescription(trans('techplanner::client.actions.populateCoordinates.modal.description'))
                ->modalSubmitActionLabel(trans('techplanner::client.actions.populateCoordinates.modal.submit_label')),
        ];

        return $actions;
    }

    private function populateAllCoordinates(): void
    {
        $batchSize = 50;
        $totalProcessed = 0;
        $totalSuccess = 0;
        $errors = [];

        Client::whereNull('latitude')
            ->orWhereNull('longitude')
            ->chunk($batchSize, function (Collection $clients) use (&$totalProcessed, &$totalSuccess, &$errors): void {
                /** @var Collection<int, Client> $clients */
                $action = app(UpdateCoordinatesFromAddressAction::class);

                foreach ($clients as $client) {
                    if (! $client instanceof Client) {
                        continue;
                    }

                    $totalProcessed++;

                    if ($action->execute($client)) {
                        $totalSuccess++;

                        continue;
                    }

                    foreach ($action->getErrors() as $error) {
                        if (! is_string($error)) {
                            continue;
                        }

                        $errors[] = 'Error updating client #'.$client->id.': '.$error;
                    }
                }
            });

        $message = __('techplanner::client.messages.coordinates_batch_summary', [
            'processed' => $totalProcessed,
            'success' => $totalSuccess,
        ]);

        if (! empty($errors)) {
            Notification::make()
                ->warning()
                ->title(__('techplanner::client.messages.coordinates_batch_warning'))
                ->body($message."\n\n".implode("\n", array_slice($errors, 0, 5)))
                ->persistent()
                ->send();

            return;
        }

        Notification::make()
            ->success()
            ->title(__('techplanner::client.messages.coordinates_batch_success'))
            ->body($message)
            ->send();
    }

    // private function updateClientCoordinates($client): void
    // {
    //     // This method is now only used for single updates
    //    use Modules\Geo\Actions\GetAddressDataFromFullAddressAction;
    //         ->execute($client->full_address);
    //     if ($addressData) {
    //         $client->update($addressData->toArray());
    //     }
    // }
    /**
     * @return Builder<Client>
     */
    protected function getTableQuery(): Builder
    {
        $query = parent::getTableQuery();
        if ($query === null) {
            throw new Exception('Query is null');
        }

        if ($query instanceof Relation) {
            /** @var Builder<Client> $query */
            $query = $query->getQuery();
        }

        if (! $query instanceof Builder) {
            throw new Exception('Query is not a Builder instance');
        }

        /** @var Builder<Client> $clientQuery */
        $clientQuery = $query->with(['latestAppointment.controls']);
        $query = $clientQuery->withLatestControlDates();

        $latitude = Session::get('user_latitude');
        $longitude = Session::get('user_longitude');

        if (! is_numeric($latitude) || ! is_numeric($longitude)) {
            return $query;
        }

        $lat = (float) $latitude;
        $lng = (float) $longitude;

        /** @var Builder<Client> $query */
        return $query->withDistance($lat, $lng);
    }

    #[On('sort-by-distance')]
    public function handleSortByDistance(): void
    {
        $this->resetTable();
    }
}
