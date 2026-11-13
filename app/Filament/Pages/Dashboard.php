<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Pages;

use Modules\TechPlanner\Filament\Widgets\DueDevicesWidget;
use Modules\TechPlanner\Filament\Widgets\TodayAppointmentsWidget;
use Modules\TechPlanner\Filament\Widgets\VerificationOverviewWidget;
use Modules\Xot\Filament\Pages\XotBaseDashboard;
use Override;

/**
 * FUN-03: la pagina iniziale del pannello era vuota. Ora mostra cosa fare oggi:
 * verifiche scadute o in scadenza e appuntamenti del giorno.
 */
class Dashboard extends XotBaseDashboard
{
    /**
     * @return array<string, mixed>
     */
    #[Override]
    public function getWidgets(): array
    {
        return [
            'overview' => VerificationOverviewWidget::class,
            'due_devices' => DueDevicesWidget::class,
            'today_appointments' => TodayAppointmentsWidget::class,
        ];
    }
}
