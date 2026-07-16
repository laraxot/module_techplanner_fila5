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

    public float $latitude = 0;

    public float $longitude = 0;

    /**
     * @return array<int, Component>
     */
    public function getFormSchema(): array
    {
        return [];
    }

    public function mount(): void
    {
        $this->latitude = app(SafeFloatCastAction::class)
            ->execute(Session::get('user_latitude', Cookie::get('user_latitude', 0)));
        $this->longitude = app(SafeFloatCastAction::class)
            ->execute(Session::get('user_longitude', Cookie::get('user_longitude', 0)));
    }

    public function updateCoordinates(): void
    {
        Session::put('user_latitude', $this->latitude);
        Session::put('user_longitude', $this->longitude);

        Cookie::queue('user_latitude', $this->latitude, 60 * 24 * 30); // 30 days
        Cookie::queue('user_longitude', $this->longitude, 60 * 24 * 30);

        $this->dispatch('coordinates-updated');

        // Ordina la tabella per distanza
        $target = 'filament.techplanner::admin.resources.clients.index';
        $dispatch = $this->dispatch('sort-by-distance');
        if (is_object($dispatch) && method_exists($dispatch, 'to')) {
            $dispatch->to($target);
        }

        Notification::make()
            ->success()
            ->title('Coordinate aggiornate')
            ->body('La tabella è stata ordinata in base alla distanza dalle coordinate impostate')
            ->send();
    }

    #[On('coordinates-updated')]
    public function refreshCoordinates(): void
    {
        $this->latitude = app(SafeFloatCastAction::class)
            ->execute(Session::get('user_latitude', Cookie::get('user_latitude', 0)));
        $this->longitude = app(SafeFloatCastAction::class)
            ->execute(Session::get('user_longitude', Cookie::get('user_longitude', 0)));
    }
}
