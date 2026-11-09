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
                ->title(trans('techplanner::client_map_widget.origin_missing.title'))
                ->body(trans('techplanner::client_map_widget.origin_missing.body'))
                ->send();

            return;
        }

        Session::put('user_latitude', (float) $latitude);
        Session::put('user_longitude', (float) $longitude);
        Cookie::queue('user_latitude', (string) $latitude, 60 * 24 * 30);
        Cookie::queue('user_longitude', (string) $longitude, 60 * 24 * 30);

        // 'coordinates-updated' fa rileggere sessione/cookie al
        // CoordinatesWidget (checkbox "posizione di riferimento");
        // 'set-client-distance-origin' fa persistere sessione/cookie e
        // chiamare resetTable() in ListClients (stesso identikit di
        // CoordinatesWidget::updateCoordinate()).
        // 'sort-by-distance' fa resettare e riordinare la tabella.
        $this->dispatch('coordinates-updated');
        $this->dispatch('set-client-distance-origin', $clientId);
        $this->dispatch('sort-by-distance');

        Notification::make()
            ->success()
            ->title(trans('techplanner::client_map_widget.origin_set.title'))
            ->body(trans('techplanner::client_map_widget.origin_set.body'))
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
            'label' => (string) trans('techplanner::client_map_widget.origin_popup'),
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

        $viewLabel = (string) trans('techplanner::client_map_widget.view');
        $editLabel = (string) trans('techplanner::client_map_widget.edit');

        return '<div class="client-map-popup" style="min-width: 200px;">'
            .'<strong>'.e($label).'</strong>'.$rows
            .'<div style="margin-top: 6px; display: flex; gap: 6px; flex-wrap: wrap; align-items: center;">'
            .$this->iconLink(
                ClientResource::getUrl('view', ['record' => $client]),
                $viewLabel,
                (string) trans('techplanner::client_map_widget.view_tooltip'),
                'M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178zM15 12a3 3 0 11-6 0 3 3 0 016 0z',
            )
            .$this->iconLink(
                ClientResource::getUrl('edit', ['record' => $client]),
                $editLabel,
                (string) trans('techplanner::client_map_widget.edit_tooltip'),
                'M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10',
            )
            .'<button type="button" class="fi-btn fi-btn-color-primary fi-btn-size-sm"'
                .' data-map-method="setDistanceOrigin" data-map-arg="'.e((string) $id).'"'
                .' title="'.e((string) trans('techplanner::client_map_widget.set_origin_tooltip')).'">'
                .e((string) trans('techplanner::client_map_widget.set_origin')).'</button>'
            .'</div></div>';
    }

    /**
     * Link icona-only (Heroicons outline) con tooltip esteso: label
     * testuale visibile solo via `title`/`aria-label`, niente chiavi
     * `filament-actions::` nel popup.
     */
    private function iconLink(string $url, string $label, string $tooltip, string $path): string
    {
        return '<a class="fi-btn fi-btn-color-gray fi-btn-size-sm fi-btn-icon" href="'.e($url).'"'
            .' title="'.e($tooltip).'" aria-label="'.e($tooltip).'"'
            .' style="display:inline-flex;align-items:center;justify-content:center;width:2rem;height:2rem;padding:0;">'
            .'<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"'
            .' style="width:1rem;height:1rem;" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="'.$path.'"/></svg>'
            .'<span class="sr-only">'.e($label).'</span></a>';
    }

    /**
     * Stringhe TechPlanner per la mappa condivisa.
     *
     * @return array{aria_label: string, fullscreen: string, fullscreen_exit: string, locate: string, layer_satellite: string, footer: string}
     */
    #[Override]
    protected function getMapStrings(int $markerCount): array
    {
        return [
            'aria_label' => (string) trans('techplanner::client_map_widget.aria_label'),
            'fullscreen' => (string) trans('techplanner::client_map_widget.fullscreen'),
            'fullscreen_exit' => (string) trans('techplanner::client_map_widget.fullscreen_exit'),
            'locate' => (string) trans('techplanner::client_map_widget.locate'),
            'layer_satellite' => (string) trans('techplanner::client_map_widget.layer_satellite'),
            'footer' => (string) trans('techplanner::client_map_widget.markers_shown', ['count' => $markerCount]),
        ];
    }
}
