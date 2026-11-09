<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ClientResource\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Modules\Geo\Actions\UpdateCoordinatesFromAddressAction;
use Modules\Geo\Filament\Actions\UpdateCoordinatesBulkAction;
use Modules\Geo\Filament\Tables\Columns\AddressColumn;
use Modules\Notify\Filament\Actions\SendRecordsNotificationBulkAction;
use Modules\Notify\Filament\Tables\Columns\ContactColumn;
use Modules\TechPlanner\Enums\ControlTypeEnum;
use Modules\TechPlanner\Models\Client;
use Modules\TechPlanner\Models\Control;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;
use Modules\Xot\Filament\Tables\Actions\XotBaseBulkAction;

class ClientsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'distance' => TextColumn::make('distance')
                ->label('km')
                ->width('5rem')
                ->extraAttributes(['class' => 'whitespace-nowrap'])
                ->formatStateUsing(static function (string|int|float|null $state): string {
                    return is_numeric($state) ? number_format((float) $state, 2).' km' : '—';
                }),
            'last_rx_control_date' => TextColumn::make('last_rx_control_date')
                ->label(__('techplanner::client.fields.last_rx_control_date.label'))
                ->date()->sortable()->placeholder('—'),
            'last_intraoral_control_date' => TextColumn::make('last_intraoral_control_date')
                ->label(__('techplanner::client.fields.last_intraoral_control_date.label'))
                ->date()->sortable()->placeholder('—')->toggleable(isToggledHiddenByDefault: true),
            'last_electromedical_control_date' => TextColumn::make('last_electromedical_control_date')
                ->label(__('techplanner::client.fields.last_electromedical_control_date.label'))
                ->date()->sortable()->placeholder('—'),
            'last_health_authorization_date' => TextColumn::make('last_health_authorization_date')
                ->label(__('techplanner::client.fields.last_health_authorization_date.label'))
                ->date()->sortable()->placeholder('—'),
            /*
             * Ultimo appuntamento: la data da sola non dice "per cosa" si e' andati
             * dal cliente — i `controls` di quell'appuntamento portano il
             * `control_type` (rx, elettromedicali, ...). Senza questa informazione
             * il tecnico non sa se la prossima chiamata e' di manutenzione RX o
             * di verifica elettromedicale.
             */
            'last_appointment' => TextColumn::make('last_appointment')
                ->label(__('techplanner::client.fields.last_appointment.label'))
                ->state(static function (Client $record): ?string {
                    $appointment = $record->latestAppointment;
                    if ($appointment === null) {
                        return null;
                    }

                    $types = $appointment->controls
                        ->map(static function (Control $control): ?ControlTypeEnum {
                            $type = $control->getAttribute('control_type');

                            return $type instanceof ControlTypeEnum ? $type : null;
                        })
                        ->filter()
                        ->unique()
                        ->map(static fn (ControlTypeEnum $type): string => $type->getLabel())
                        ->implode(', ');

                    $date = $appointment->date?->format('d/m/Y');

                    return $types === '' ? $date : $date.' — '.$types;
                })
                ->placeholder('—')
                ->icon('heroicon-o-calendar-days')
                ->iconColor('gray')
                ->wrap(),
            'longitude' => TextColumn::make('longitude')->sortable()->toggleable(isToggledHiddenByDefault: true),
            'latitude' => TextColumn::make('latitude')->sortable()->toggleable(isToggledHiddenByDefault: true),
            'business_closed' => TextColumn::make('business_closed')->toggleable(isToggledHiddenByDefault: true),
            // Telefono: la card ha una riga per colonna. Di un cliente servono nome, distanza, indirizzo e contatti
            // (chiamare/navigare); l'attivita' merceologica compare da `md`.
            'activity' => TextColumn::make('activity')
                ->searchable()
                ->sortable()
                ->wrap()
                ->visibleFrom('md'),
            'company_name' => TextColumn::make('company_name')
                ->searchable()
                ->sortable()
                ->wrap(),
            'fiscal_code' => TextColumn::make('fiscal_code')->toggleable(isToggledHiddenByDefault: true),
            /*
            'full_address' => TextColumn::make('full_address')
                ->searchable(['city', 'company_office', 'postal_code', 'province', 'country', 'address'])
                ->sortable()
                ->wrap(),

            'city' => TextColumn::make('city')->toggleable(isToggledHiddenByDefault: true),
            'province' => TextColumn::make('province')->toggleable(isToggledHiddenByDefault: true),
            'country' => TextColumn::make('country')->toggleable(isToggledHiddenByDefault: true),
            'updated_at' => TextColumn::make('updated_at')->toggleable(isToggledHiddenByDefault: true)->sortable(),
            'created_at' => TextColumn::make('created_at')->toggleable(isToggledHiddenByDefault: true)->sortable(),

            */
            'address' => AddressColumn::make('address'),
            'contacts' => ContactColumn::make('contacts'),
        ];
    }

    /**
     * Keep distance filters/actions on the resource table: Xot builds the
     * Filament table from this class, not from ListClients.
     *
     * @return array<int|string, BaseFilter>
     */
    public function getTableFilters(): array
    {
        $activities = Cache::remember('client_activities_filter', 3600, static fn (): array => Client::query()
            ->whereNotNull('activity')
            ->distinct()
            ->limit(100)
            ->pluck('activity', 'activity')
            ->map(SafeStringCastAction::cast(...))
            ->toArray()
        );

        /** @var array<string, string> $activities */
        return [
            TernaryFilter::make('business_closed')->default(false),
            SelectFilter::make('activity')->multiple()->preload()->options($activities),
            TernaryFilter::make('has_controls')
                ->label(__('techplanner::client.filters.has_controls.label'))
                ->queries(
                    true: fn (Builder $query) => $query->whereHas('controls'),
                    false: fn (Builder $query) => $query->whereDoesntHave('controls'),
                    blank: fn (Builder $query) => $query,
                ),
            Filter::make('controls_expiring')
                ->label(__('techplanner::client.filters.controls_expiring.label'))
                ->query(fn (Builder $query) => $query->whereHas(
                    'controls',
                    static fn (Builder $controls) => $controls->whereDate('next_control_date', '<=', now()->addDays(30)),
                )),
            SelectFilter::make('last_appointment_type')
                ->label(__('techplanner::client.filters.last_appointment_type.label'))
                ->options(static fn (): array => collect(ControlTypeEnum::cases())
                    ->mapWithKeys(static fn (ControlTypeEnum $type): array => [$type->value => $type->getLabel()])
                    ->put('none', __('techplanner::client.filters.last_appointment_type.none'))
                    ->all())
                ->query(static function (Builder $query, array $data): Builder {
                    $value = $data['value'] ?? null;
                    if (! is_string($value) || $value === '') {
                        return $query;
                    }

                    // "Nessun appuntamento" isola i clienti mai visitati.
                    if ($value === 'none') {
                        return $query->whereDoesntHave('appointments');
                    }

                    // whereHas su `latestAppointment` (hasOne latestOfMany) limita
                    // il controllo ALL'ultimo appuntamento, non a qualunque storico.
                    return $query->whereHas('latestAppointment', static fn (Builder $appointments): Builder => $appointments
                        ->whereHas('controls', static fn (Builder $controls): Builder => $controls->where('control_type', $value)));
                }),
            SelectFilter::make('never_controlled_type')
                ->label(__('techplanner::client.filters.never_controlled_type.label'))
                ->options(static fn (): array => collect(ControlTypeEnum::cases())
                    ->mapWithKeys(static fn (ControlTypeEnum $type): array => [$type->value => $type->getLabel()])
                    ->all())
                ->query(static fn (Builder $query, array $data): Builder => ($data['value'] ?? null) === null
                    ? $query
                    : $query->whereDoesntHave('controls', static fn (Builder $controls) => $controls->where('control_type', $data['value']))),
            TernaryFilter::make('has_rx_control')
                ->label(__('techplanner::client.filters.has_rx_control.label'))
                ->queries(
                    true: static fn (Builder $query): Builder => $query->whereHas('controls', static fn (Builder $controls): Builder => $controls
                        ->whereIn('control_type', [ControlTypeEnum::RX->value, ControlTypeEnum::INTRAORAL->value])),
                    false: static fn (Builder $query): Builder => $query->whereDoesntHave('controls', static fn (Builder $controls): Builder => $controls
                        ->whereIn('control_type', [ControlTypeEnum::RX->value, ControlTypeEnum::INTRAORAL->value])),
                    blank: static fn (Builder $query): Builder => $query,
                ),
            TernaryFilter::make('has_electromedical_control')
                ->label(__('techplanner::client.filters.has_electromedical_control.label'))
                ->queries(
                    true: static fn (Builder $query): Builder => $query->whereHas('controls', static fn (Builder $controls): Builder => $controls
                        ->where('control_type', ControlTypeEnum::ELECTROMEDICAL->value)),
                    false: static fn (Builder $query): Builder => $query->whereDoesntHave('controls', static fn (Builder $controls): Builder => $controls
                        ->where('control_type', ControlTypeEnum::ELECTROMEDICAL->value)),
                    blank: static fn (Builder $query): Builder => $query,
                ),
            TernaryFilter::make('has_health_authorization')
                ->label(__('techplanner::client.filters.has_health_authorization.label'))
                ->queries(
                    true: static fn (Builder $query): Builder => $query->whereHas('controls', static fn (Builder $controls): Builder => $controls
                        ->where('control_type', ControlTypeEnum::HEALTH_AUTHORIZATION->value)),
                    false: static fn (Builder $query): Builder => $query->whereDoesntHave('controls', static fn (Builder $controls): Builder => $controls
                        ->where('control_type', ControlTypeEnum::HEALTH_AUTHORIZATION->value)),
                    blank: static fn (Builder $query): Builder => $query,
                ),
        ];
    }

    /**
     * @return array<int|string, Action|ActionGroup>
     */
    public function getTableActions(): array
    {
        return [
            ...parent::getTableActions(),
            Action::make('sortByDistance')
                ->icon('heroicon-o-map')
                ->iconButton()
                ->label(__('techplanner::client_map_widget.set_origin_tooltip'))
                ->tooltip(__('techplanner::client_map_widget.set_origin_tooltip'))
                ->action(static function (Client $record): void {
                    self::ensureClientCoordinates($record);

                    $latitude = $record->getAttribute('latitude');
                    $longitude = $record->getAttribute('longitude');

                    if (! is_numeric($latitude) || ! is_numeric($longitude)) {
                        Notification::make()
                            ->warning()
                            ->title(__('techplanner::client_map_widget.origin_missing.title'))
                            ->body(__('techplanner::client_map_widget.origin_missing_geocode_failed.body'))
                            ->send();

                        return;
                    }

                    Session::put('user_latitude', (float) $latitude);
                    Session::put('user_longitude', (float) $longitude);
                    Cookie::queue('user_latitude', (string) $latitude, 60 * 24 * 30);
                    Cookie::queue('user_longitude', (string) $longitude, 60 * 24 * 30);

                    Notification::make()
                        ->success()
                        ->title(__('techplanner::client_map_widget.origin_set.title'))
                        ->body(__('techplanner::client_map_widget.origin_set.body'))
                        ->send();
                }),
        ];
    }

    /**
     * @return array<int|string, XotBaseBulkAction>
     */
    public function getTableBulkActions(): array
    {
        return [
            'updateCoordinates' => UpdateCoordinatesBulkAction::make('updateCoordinates'),
            'sendRecordsNotification' => SendRecordsNotificationBulkAction::make('sendRecordsNotification'),
        ];
    }

    /**
     * Popola le coordinate del cliente geocodificando il suo indirizzo quando
     * mancano; riusa la stessa action dell'aggiornamento batch.
     */
    private static function ensureClientCoordinates(Client $client): void
    {
        $latitude = $client->getAttribute('latitude');
        $longitude = $client->getAttribute('longitude');

        if (is_numeric($latitude) && is_numeric($longitude)) {
            return;
        }

        app(UpdateCoordinatesFromAddressAction::class)->execute($client);
        $client->refresh();
    }
}
