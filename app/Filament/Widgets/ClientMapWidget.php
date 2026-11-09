<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Widgets;

use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Modules\Geo\Filament\Widgets\BaseMapWidget;
use Modules\TechPlanner\Filament\Resources\ClientResource;
use Modules\TechPlanner\Models\Client;
use Modules\Xot\Actions\Cast\SafeFloatCastAction;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Override;

/**
 * Mappa clienti per la pianificazione delle uscite.
 *
 * Estende `BaseMapWidget` (Geo): marker, cluster, controlli e fullscreen
 * sono forniti dalla vista condivisa `geo::filament.widgets.base-map`.
 * Questo widget dichina solo i dati (client con coordinate), l'origine
 * per le distanze e le stringhe di traduzione TechPlanner.
 */
class ClientMapWidget extends BaseMapWidget
{
    /*
     * La mappa e' il widget principale della lista clienti (punti visita,
     * marker, origine per le distanze): il lazy-load Livewire la rendeva
     * fragile — la request di resume riceveva HTML invece di JSON e la
     * mappa non appariva mai. Render eager nel payload iniziale.
     */
    protected static ?bool $isLazyLoaded = false;

    protected int $maxMarkers = 500;

    /**
     * Imposta le coordinate di un cliente come punto di riferimento
     * per l'ordinamento per distanza nella tabella clienti.
     * Chiamato dalla mappa via `data-map-method="setDistanceOrigin"`.
     */
    public function setDistanceOrigin(int $clientId): void
    {
        $client = Client::query()->find($clientId);
        $latitude = $client?->getAttribute('latitude');
        $longitude = $client?->getAttribute('longitude');

        if (! $client instanceof Client
            || ! is_numeric($latitude)
            || ! is_numeric($longitude)
        ) {
            Notification::make()
                ->warning()
                ->title(trans('techplanner::client.map.origin_missing.title'))
                ->body(trans('techplanner::client.map.origin_missing.body'))
                ->send();

            return;
        }

        Session::put('user_latitude', (float) $latitude);
        Session::put('user_longitude', (float) $longitude);
        Cookie::queue('user_latitude', (string) $latitude, 60 * 24 * 30);
        Cookie::queue('user_longitude', (string) $longitude, 60 * 24 * 30);

        $this->dispatch('sort-by-distance');

        Notification::make()
            ->success()
            ->title(trans('techplanner::client.map.origin_set.title'))
            ->body(trans('techplanner::client.map.origin_set.body'))
            ->send();
    }

    /**
     * Coordinate del punto di riferimento corrente (sessione/cookie),
     * esposto alla mappa per il marker dedicato.
     *
     * @return array{latitude: float|null, longitude: float|null, label: string}
     */
    #[Override]
    protected function getMapOrigin(): array
    {
        $latitude = Session::get('user_latitude', Cookie::get('user_latitude'));
        $longitude = Session::get('user_longitude', Cookie::get('user_longitude'));

        return [
            'latitude' => is_numeric($latitude) ? (float) $latitude : null,
            'longitude' => is_numeric($longitude) ? (float) $longitude : null,
            'label' => (string) trans('techplanner::client.map.origin_popup'),
        ];
    }

    /**
     * @return array<int, array{id: int|string, label: string, latitude: float, longitude: float, popup: string}>
     */
    #[Override]
    public function getMapMarkers(): array
    {
        return Client::query()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->orderBy('company_name')
            ->limit($this->maxMarkers)
            ->get([
                'id', 'name', 'company_name', 'address', 'city', 'postal_code',
                'province', 'route', 'street_number',
                'phone', 'mobile', 'whatsapp', 'latitude', 'longitude',
            ])
            ->map(function (Client $client): array {
                $safeString = app(SafeStringCastAction::class);
                $label = $safeString->execute($client->company_name ?: $client->name)
                    ?: 'Client #'.$safeString->execute($client->getKey());
                $id = $safeString->execute($client->getKey());

                return [
                    'id' => $id,
                    'label' => $label,
                    'latitude' => app(SafeFloatCastAction::class)->execute($client->getAttribute('latitude')),
                    'longitude' => app(SafeFloatCastAction::class)->execute($client->getAttribute('longitude')),
                    'popup' => $this->buildMarkerPopup($client, $label, $id),
                ];
            })
            ->all();
    }

    /**
     * Popup del marker: HTML costruito server-side (escape via e()),
     * con link view/edit e azione Livewire dichiarativa
     * `data-map-method="setDistanceOrigin"` instradata dalla vista base.
     */
    private function buildMarkerPopup(Client $client, string $label, int|string $id): string
    {
        $safeString = app(SafeStringCastAction::class);
        $address = $safeString->execute($client->getAttribute('full_address'));
        $phone = $safeString->execute($client->getAttribute('phone') ?: $client->getAttribute('mobile'));

        $rows = ($address !== '' ? '<div>'.e($address).'</div>' : '')
            .($phone !== '' ? '<div><a href="tel:'.e($phone).'">'.e($phone).'</a></div>' : '');

        return '<div class="client-map-popup" style="min-width: 200px;">'
            .'<strong>'.e($label).'</strong>'.$rows
            .'<div style="margin-top: 6px; display: flex; gap: 6px; flex-wrap: wrap;">'
            .'<a class="fi-btn fi-btn-color-gray fi-btn-size-sm" href="'.e(ClientResource::getUrl('view', ['record' => $client])).'">'
                .e((string) trans('filament-actions::modal.view.actions.view.label')).'</a>'
            .'<a class="fi-btn fi-btn-color-gray fi-btn-size-sm" href="'.e(ClientResource::getUrl('edit', ['record' => $client])).'">'
                .e((string) trans('filament-actions::modal.edit.actions.edit.label')).'</a>'
            .'<button type="button" class="fi-btn fi-btn-color-primary fi-btn-size-sm"'
                .' data-map-method="setDistanceOrigin" data-map-arg="'.e((string) $id).'">'
                .e((string) trans('techplanner::client.map.set_origin')).'</button>'
            .'</div></div>';
    }

    /**
     * Stringhe TechPlanner per la mappa condivisa.
     *
     * @return array{aria_label: string, fullscreen: string, locate: string, layer_satellite: string, footer: string}
     */
    #[Override]
    protected function getMapStrings(int $markerCount): array
    {
        return [
            'aria_label' => (string) trans('techplanner::client.map.aria_label'),
            'fullscreen' => (string) trans('techplanner::client.map.fullscreen'),
            'locate' => (string) trans('techplanner::client.map.locate'),
            'layer_satellite' => (string) trans('techplanner::client.map.layer_satellite'),
            'footer' => (string) trans('techplanner::client.map.markers_shown', ['count' => $markerCount]),
        ];
    }
}
