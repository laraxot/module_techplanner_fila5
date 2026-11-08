<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Widgets;

use Filament\Notifications\Notification;
use Filament\Schemas\Components\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Modules\TechPlanner\Filament\Resources\ClientResource;
use Modules\TechPlanner\Models\Client;
use Modules\Xot\Actions\Cast\SafeFloatCastAction;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class ClientMapWidget extends XotBaseWidget
{
    protected string $view = 'techplanner::filament.widgets.client-map';

    protected int|string|array $columnSpan = 'full';

    private const int MAX_MARKERS = 500;

    /**
     * @return array<int, Component>
     */
    public function getFormSchema(): array
    {
        return [];
    }

    /**
     * Imposta le coordinate di un cliente come punto di riferimento
     * per l'ordinamento per distanza nella tabella clienti.
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
     * @return array{latitude: float|null, longitude: float|null}
     */
    protected function getOrigin(): array
    {
        $latitude = Session::get('user_latitude', Cookie::get('user_latitude'));
        $longitude = Session::get('user_longitude', Cookie::get('user_longitude'));

        return [
            'latitude' => is_numeric($latitude) ? (float) $latitude : null,
            'longitude' => is_numeric($longitude) ? (float) $longitude : null,
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function getMarkers(): array
    {
        return Client::query()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->orderBy('company_name')
            ->limit(self::MAX_MARKERS)
            ->get([
                'id', 'name', 'company_name', 'address', 'city', 'postal_code',
                'province', 'route', 'street_number',
                'phone', 'mobile', 'whatsapp', 'latitude', 'longitude',
            ])
            ->map(static function (Client $client): array {
                $safeString = app(SafeStringCastAction::class);

                return [
                    'id' => $client->getKey(),
                    'label' => $safeString->execute($client->company_name ?: $client->name) ?: 'Client #'.$safeString->execute($client->getKey()),
                    'address' => $safeString->execute($client->getAttribute('full_address')),
                    'phone' => $safeString->execute($client->getAttribute('phone') ?: $client->getAttribute('mobile')),
                    'whatsapp' => $safeString->execute($client->getAttribute('whatsapp')),
                    'latitude' => app(SafeFloatCastAction::class)->execute($client->getAttribute('latitude')),
                    'longitude' => app(SafeFloatCastAction::class)->execute($client->getAttribute('longitude')),
                    'view_url' => ClientResource::getUrl('view', ['record' => $client]),
                    'edit_url' => ClientResource::getUrl('edit', ['record' => $client]),
                ];
            })
            ->all();
    }

    /**
     * @return array<string, mixed>
     */
    protected function getData(): array
    {
        return [
            'markers' => $this->getMarkers(),
            'origin' => $this->getOrigin(),
            'asset_base' => asset('assets/geo/assets'),
        ];
    }

    public function render(): View
    {
        /** @var array<string, mixed> $data */
        $data = $this->getData();

        return view($this->view, $data);
    }
}
