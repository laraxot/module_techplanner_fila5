<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Modules\Xot\Providers\XotBaseServiceProvider;

class TechPlannerServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'TechPlanner';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    public function register(): void
    {
        parent::register();

        // Digest giornaliero dei controlli in scadenza: risolto solo in contesto
        // console (schedule:run / schedule:work), mai nelle richieste HTTP.
        $this->callAfterResolving(Schedule::class, function (Schedule $schedule): void {
            $schedule->command('techplanner:controls:expiring-reminder')->dailyAt('07:00');
            $schedule->command('techplanner:appointments:reminders')->dailyAt('08:00');
        });
    }
}
