<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Modules\TechPlanner\Actions\UpdateAllClientCoordinatesAction;

class UpdateClientCoordinatesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'techplanner:clients-update-coordinates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update latitude and longitude for all clients in TechPlanner';

    /**
     * Execute the console command.
     */
    public function handle(UpdateAllClientCoordinatesAction $action): int
    {
        $this->info('Starting to update client coordinates...');

        try {
            $action->execute();
            $this->info('Successfully updated client coordinates.');

            return 0;
        } catch (Exception $e) {
            $this->error("Failed to update coordinates: {$e->getMessage()}");

            return 1;
        }
    }
}
