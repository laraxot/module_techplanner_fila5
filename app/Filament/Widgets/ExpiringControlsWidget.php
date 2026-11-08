<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Widgets;

use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Schema;
use Modules\TechPlanner\Models\Control;
use Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget;

/**
 * Panoramica delle scadenze dei controlli periodici.
 *
 * Equivalente al "preventive maintenance expiry" dei concorrenti FSM/CMMS:
 * evidenzia controlli scaduti, in scadenza entro 30 giorni e quanti clienti
 * sono interessati, così l'ufficio pianifica le visite prima della scadenza.
 */
class ExpiringControlsWidget extends XotBaseStatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    /**
     * @return array<Stat>
     */
    protected function getStats(): array
    {
        return cache()->remember('techplanner.controls.expiring.stats', 900, function (): array {
            if (! Schema::hasTable('controls')) {
                return [
                    Stat::make(__('techplanner::control.widget.expired'), 0)->color('gray'),
                    Stat::make(__('techplanner::control.widget.expiring'), 0)->color('gray'),
                    Stat::make(__('techplanner::control.widget.unplanned'), 0)->color('gray'),
                    Stat::make(__('techplanner::control.widget.clients_affected'), 0)->color('gray'),
                ];
            }

            $today = Carbon::today();
            $horizon = $today->copy()->addDays(30);

            $expired = Control::query()
                ->whereNotNull('next_control_date')
                ->whereDate('next_control_date', '<', $today)
                ->count();

            $expiring = Control::query()
                ->whereNotNull('next_control_date')
                ->whereDate('next_control_date', '>=', $today)
                ->whereDate('next_control_date', '<=', $horizon)
                ->count();

            $unplanned = Control::query()
                ->whereNull('next_control_date')
                ->count();

            $clientsAffected = Control::query()
                ->whereNotNull('next_control_date')
                ->whereDate('next_control_date', '<=', $horizon)
                ->distinct()
                ->count('client_id');

            return [
                Stat::make(__('techplanner::control.widget.expired'), $expired)
                    ->descriptionIcon('heroicon-m-exclamation-triangle')
                    ->color($expired > 0 ? 'danger' : 'success'),
                Stat::make(__('techplanner::control.widget.expiring'), $expiring)
                    ->descriptionIcon('heroicon-m-clock')
                    ->color($expiring > 0 ? 'warning' : 'success'),
                Stat::make(__('techplanner::control.widget.unplanned'), $unplanned)
                    ->descriptionIcon('heroicon-m-question-mark-circle')
                    ->color('gray'),
                Stat::make(__('techplanner::control.widget.clients_affected'), $clientsAffected)
                    ->descriptionIcon('heroicon-m-users')
                    ->color('primary'),
            ];
        });
    }
}
