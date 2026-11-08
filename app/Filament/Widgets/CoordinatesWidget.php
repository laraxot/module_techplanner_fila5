<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Widgets;

use Filament\Notifications\Notification;
use Filament\Schemas\Components\Component;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;
use Modules\Xot\Actions\Cast\SafeFloatCastAction;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class CoordinatesWidget extends XotBaseWidget
{
    protected string $view = 'techplanner::filament.widgets.coordinates-widget';

    public string|float|null $latitude = '0';

    public string|float|null $longitude = '0';

    /**
     * @return array<int, Component>
     */
    public function getFormSchema(): array
    {
        return [];
    }

    public function mount(): void
    {
        $this->latitude = (string) app(SafeFloatCastAction::class)
            ->execute(Session::get('user_latitude', Cookie::get('user_latitude', 0)));
        $this->longitude = (string) app(SafeFloatCastAction::class)
            ->execute(Session::get('user_longitude', Cookie::get('user_longitude', 0)));
    }

    public function updateCoordinates(): void
    {
        if (! $this->coordinatesAreValid()) {
            Notification::make()
                ->danger()
                ->title(__('techplanner::coordinates_widget.notifications.invalid.title'))
                ->body(__('techplanner::coordinates_widget.notifications.invalid.body'))
                ->send();

            return;
        }

        $latitude = (float) $this->latitude;
        $longitude = (float) $this->longitude;
        Session::put('user_latitude', $latitude);
        Session::put('user_longitude', $longitude);

        Cookie::queue('user_latitude', (string) $latitude, 60 * 24 * 30); // 30 days
        Cookie::queue('user_longitude', (string) $longitude, 60 * 24 * 30);

        $this->dispatch('coordinates-updated');

        // Livewire propaga l'evento a tutti i componenti: ListClients lo riceve
        // via #[On('sort-by-distance')] e riapplica la query con withDistance().
        $this->dispatch('sort-by-distance');

        Notification::make()
            ->success()
            ->title(__('techplanner::coordinates_widget.notifications.updated.title'))
            ->body(__('techplanner::coordinates_widget.notifications.updated.body'))
            ->send();
    }

    private function coordinatesAreValid(): bool
    {
        return is_numeric($this->latitude) && is_numeric($this->longitude)
            && is_finite((float) $this->latitude) && is_finite((float) $this->longitude)
            && (float) $this->latitude >= -90.0 && (float) $this->latitude <= 90.0
            && (float) $this->longitude >= -180.0 && (float) $this->longitude <= 180.0;
    }

    #[On('coordinates-updated')]
    public function refreshCoordinates(): void
    {
        $this->latitude = (string) app(SafeFloatCastAction::class)
            ->execute(Session::get('user_latitude', Cookie::get('user_latitude', 0)));
        $this->longitude = (string) app(SafeFloatCastAction::class)
            ->execute(Session::get('user_longitude', Cookie::get('user_longitude', 0)));
    }
}
