<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Widgets;

use Filament\Schemas\Components\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Modules\TechPlanner\Models\Client;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class ClientMapWidget extends XotBaseWidget
{
    protected string $view = 'techplanner::filament.widgets.map';

    protected int|string|array $columnSpan = 'full';

    /**
     * @return array<int, Component>
     */
    public function getFormSchema(): array
    {
        return [];
    }

    /**
     * Ottiene i dati dei clienti per la mappa.
     *
     * @return array<string, mixed>
     */
    protected function getData(): array
    {
        return [
            'clients' => $this->getClientsQuery()
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->limit(500) // Limit to prevent memory issues
                ->get(['latitude', 'longitude', 'name'])
                ->toArray(),
        ];
    }

    /**
     * Ottiene la query per i clienti.
     */
    /**
     * @return Builder<Client>
     */
    protected function getClientsQuery(): Builder
    {
        return Client::query();
    }

    public function render(): View
    {
        /** @var array<string, mixed> */
        $data = $this->getData();

        return view($this->view, $data);
    }
}
