<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\TechPlanner\Filament\Resources\AppointmentResource;
use Modules\TechPlanner\Filament\Resources\DeviceResource;
use Modules\TechPlanner\Filament\Resources\DeviceResource\Tables\DevicesTable;
use Modules\TechPlanner\Models\Appointment;
use Modules\TechPlanner\Models\Device;
use Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget;
use Override;

/**
 * FUN-03: i numeri da guardare ogni mattina. Ogni riquadro apre l'elenco già filtrato.
 */
class VerificationOverviewWidget extends XotBaseStatsOverviewWidget
{
    protected static ?int $sort = 1;

    /** Numeri giornalieri: niente aggiornamento automatico ogni 5 secondi (default Filament). */
    protected ?string $pollingInterval = null;

    protected int|string|array $columnSpan = 'full';

    /**
     * @return array<int, Stat>
     */
    #[Override]
    protected function getStats(): array
    {
        $overdue = Device::query()->verificationDueBy(today()->subDay())->count();
        $dueSoon = Device::query()->verificationDueBy(today()->addDays(DevicesTable::DUE_SOON_DAYS))->count() - $overdue;
        $never = Device::query()->neverVerified()->count();
        $today = Appointment::query()->whereDate('date', today())->count();

        return [
            Stat::make(__('techplanner::dashboard.stats.overdue.label'), $overdue)
                ->description(__('techplanner::dashboard.stats.overdue.description'))
                ->icon('heroicon-o-exclamation-triangle')
                ->color($overdue > 0 ? 'danger' : 'success')
                ->url(DeviceResource::getUrl('index', ['filters' => ['due' => ['value' => 'overdue']]])),
            Stat::make(__('techplanner::dashboard.stats.due_soon.label'), $dueSoon)
                ->description(__('techplanner::dashboard.stats.due_soon.description', ['days' => DevicesTable::DUE_SOON_DAYS]))
                ->icon('heroicon-o-clock')
                ->color($dueSoon > 0 ? 'warning' : 'success')
                ->url(DeviceResource::getUrl('index', ['filters' => ['due' => ['value' => (string) DevicesTable::DUE_SOON_DAYS]]])),
            Stat::make(__('techplanner::dashboard.stats.never.label'), $never)
                ->description(__('techplanner::dashboard.stats.never.description'))
                ->icon('heroicon-o-question-mark-circle')
                ->color($never > 0 ? 'gray' : 'success')
                ->url(DeviceResource::getUrl('index', ['filters' => ['due' => ['value' => 'never']]])),
            Stat::make(__('techplanner::dashboard.stats.appointments_today.label'), $today)
                ->description(__('techplanner::dashboard.stats.appointments_today.description'))
                ->icon('heroicon-o-calendar-days')
                ->color('primary')
                ->url(AppointmentResource::getUrl('index')),
        ];
    }
}
