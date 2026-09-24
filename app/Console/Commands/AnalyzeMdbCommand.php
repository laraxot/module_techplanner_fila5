<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Console\Commands;

use Modules\Xot\Console\Commands\XotBaseCommand;
use Symfony\Component\Process\Process;

use function Safe\chmod;

class AnalyzeMdbCommand extends XotBaseCommand
{
    protected $signature = 'techplanner:analyze-mdb {mdb_path?}';

    protected $description = 'Analyze MDB structure using shell scripts';

    public function handle(): int
    {
        $mdbPath = $this->argument('mdb_path');
        $mdbPath = is_string($mdbPath) ? $mdbPath : '/mnt/nas02/var/www/_bases/Sottana.com/Sorvegli01.mdb';

        if (! file_exists($mdbPath)) {
            $this->error("File not found: {$mdbPath}");

            return self::FAILURE;
        }

        $scriptsPath = module_path('TechPlanner', 'scripts');

        // Make scripts executable
        chmod($scriptsPath.'/analyze_mdb_tables.sh', 0o755);
        chmod($scriptsPath.'/analyze_mdb_relations.sh', 0o755);

        // Run analysis scripts
        $this->info('Analyzing tables...');
        $tablesProcess = new Process([$scriptsPath.'/analyze_mdb_tables.sh', $mdbPath]);
        $tablesProcess->run();

        if (! $tablesProcess->isSuccessful()) {
            $this->error($tablesProcess->getErrorOutput());

            return self::FAILURE;
        }

        $this->info($tablesProcess->getOutput());

        $this->info('Analyzing relationships...');
        $relationsProcess = new Process([$scriptsPath.'/analyze_mdb_relations.sh', $mdbPath]);
        $relationsProcess->run();

        if (! $relationsProcess->isSuccessful()) {
            $this->error($relationsProcess->getErrorOutput());

            return self::FAILURE;
        }

        $this->info($relationsProcess->getOutput());

        $this->info('Analysis completed. Check Modules/TechPlanner/database/mdb_analysis/ for results.');

        return self::SUCCESS;
    }
}
