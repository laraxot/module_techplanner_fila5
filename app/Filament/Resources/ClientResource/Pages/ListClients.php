<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ClientResource\Pages;

use Exception;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\ImportAction;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;
use Modules\Geo\Actions\UpdateCoordinatesFromAddressAction;
use Modules\Geo\Filament\Actions\UpdateCoordinatesBulkAction;
use Modules\Notify\Filament\Actions\SendRecordsNotificationBulkAction;
use Modules\TechPlanner\Filament\Imports\ClientImporter;
use Modules\TechPlanner\Filament\Resources\ClientResource;
use Modules\TechPlanner\Filament\Resources\ClientResource\Tables\ClientsTable;
use Modules\TechPlanner\Models\Client;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
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
            // \Modules\TechPlanner\Filament\Widgets\ClientMapWidget::class, //WIP
        ];
    }

    /**
     * Summary of getListTableColumns.
     */
    public function getTableColumns(): array
    {
        /** @var Collection<int, Client> $rows */
        $rows = Client::whereNull('route')->whereNotNull('address')->get();
        foreach ($rows as $row) {
            if ($row instanceof Client) {
                $row->update([
                    'route' => $row->address,
                ]);
            }
        }

        return (new ClientsTable())->getTableColumns();
    }

    public function getTableFilters(): array
    {
        // Cache del filtro attività per ridurre query e memory usage
        $activities = Cache::remember('client_activities_filter', 3600, function () {
            return static::getModel()::query()
                ->whereNotNull('activity')
                ->distinct()
                ->limit(100) // Limitare il numero di attività per evitare overhead
                ->pluck('activity', 'activity')
                ->map(app(SafeStringCastAction::class)->execute(...))
                ->toArray();
        });

        /** @var array<string, string> $activities */

        return [
            ...parent::getTableFilters(),
            TernaryFilter::make('business_closed')->default(false),
            SelectFilter::make('activity')
                ->multiple()
                ->preload()
                ->options($activities),
        ];
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
                ->action(function () {
                    $this->populateAllCoordinates();
                })
                ->requiresConfirmation()
                ->modalHeading(trans('tech_planner::client.actions.populateCoordinates.modal.heading'))
                ->modalDescription(trans('tech_planner::client.actions.populateCoordinates.modal.description'))
                ->modalSubmitActionLabel(trans('tech_planner::client.actions.populateCoordinates.modal.submit_label')),
        ];

        return $actions;
    }

    public function getTableBulkActions(): array
    {
        return [
            'updateCoordinates' => UpdateCoordinatesBulkAction::make('updateCoordinates'),
            'sendRecordsNotification' => SendRecordsNotificationBulkAction::make('sendRecordsNotification'),
        ];
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

        $message = "Processed {$totalProcessed} clients. Successfully updated {$totalSuccess} coordinates.";

        if (! empty($errors)) {
            Notification::make()
                ->warning()
                ->title('Coordinate Update Completed with Errors')
                ->body($message."\n\n".implode("\n", array_slice($errors, 0, 5)))
                ->persistent()
                ->send();

            return;
        }

        Notification::make()
            ->success()
            ->title('Coordinates Updated Successfully')
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
     * @return array<int|string, Action|ActionGroup>
     */
    /**
     * {@inheritDoc}
     *
     * @return array<string, Action|ActionGroup>
     */
    /**
     * {@inheritDoc}
     *
     * @return array<string, Action|ActionGroup>
     */
    public function getTableActions(): array
    {
        /** @var array<string, Action|ActionGroup> $actions */
        $actions = [
            ...parent::getTableActions(),
            Action::make('sortByDistance')
                ->icon('heroicon-o-map')
                ->action(function (Client $record) {
                    $latValue = $record->getAttribute('latitude');
                    $lngValue = $record->getAttribute('longitude');
                    $latitude = is_numeric($latValue) ? (float) $latValue : null;
                    $longitude = is_numeric($lngValue) ? (float) $lngValue : null;
                    if ($latitude === null || $longitude === null) {
                        Notification::make()
                            ->warning()
                            ->title('Attenzione')
                            ->body('Il cliente selezionato non ha coordinate valide')
                            ->send();

                        return;
                    }

                    Session::put('user_latitude', $latitude);
                    Session::put('user_longitude', $longitude);

                    // Aggiorna i cookie per persistenza
                    Cookie::queue('user_latitude', (string) $latitude, 60 * 24 * 30); // 30 giorni
                    Cookie::queue('user_longitude', (string) $longitude, 60 * 24 * 30);

                    // Aggiorna il widget delle coordinate
                    $this->dispatch('coordinates-updated');

                    // Applica l'ordinamento per distanza
                    $this->applySort('distance');

                    Notification::make()
                        ->success()
                        ->title('Coordinate aggiornate')
                        ->body('La tabella è stata ordinata in base alla distanza dal cliente selezionato')
                        ->send();
                })
                ->label('Ordina per distanza'),
        ];

        return $actions;
    }

    public function applySort(string $field): void
    {
        if ($field === 'distance') {
            $this->resetTable();
        }
    }

    #[On('sort-by-distance')]
    public function handleSortByDistance(): void
    {
        $this->applySort('distance');
    }

    /**
     * @return Builder<Client>
     */
    protected function getTableQuery(): Builder
    {
        $query = parent::getTableQuery();
        if ($query === null) {
            throw new Exception('Query is null');
        }

        // Ensure we return a Builder, not a Relation
        if ($query instanceof Relation) {
            /** @var Builder<Client> */
            $query = $query->getQuery();
        }

        // Ensure we have a proper Builder instance
        if (! $query instanceof Builder) {
            throw new Exception('Query is not a Builder instance');
        }

        /** @var Builder<Client> $query */
        $latitude = Session::get('user_latitude');
        $longitude = Session::get('user_longitude');

        /** @var Builder<Client> $query */
        return $query->when($latitude && $longitude, function (Builder $q) use ($latitude, $longitude): Builder {
            $lat = is_numeric($latitude) ? (float) $latitude : 0.0;
            $lng = is_numeric($longitude) ? (float) $longitude : 0.0;

            /** @var Builder<Client> $q */
            return $q->withDistance($lat, $lng)->orderByDistance($lat, $lng);
        });
    }
}
