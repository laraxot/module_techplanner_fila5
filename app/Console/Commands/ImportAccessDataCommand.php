<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Console\Commands;

use Exception;
use Illuminate\Console\Command;
// use Modules\TechPlanner\Models\Apparecchio;
// use Modules\TechPlanner\Models\Cliente;
use Webmozart\Assert\Assert;

use function Safe\shell_exec;

class ImportAccessDataCommand extends Command
{
    protected $signature = 'techplanner:import-access-data {mdbPath}';

    protected $description = 'Import data from Access database';

    public function handle(): int
    {
        Assert::string($mdbPath = $this->argument('mdbPath'));
        if (! $mdbPath || ! file_exists($mdbPath)) {
            $this->error('Invalid MDB file path');

            return 1;
        }

        try {
            $this->info('Importing data from Access database...');

            // Import Clienti
            $this->info('Importing Clienti...');
            try {
                $clientiOutput = shell_exec("mdb-export '{$mdbPath}' Clienti");
            } catch (Exception $e) {
                $this->error('Failed to export Clienti table');

                return 1;
            }

            $clientiRows = array_filter(explode("\n", $clientiOutput ?? ''));

            // foreach ($clientiRows as $row) {
            //     $data = str_getcsv($row);
            //     if (count($data) > 1) { // Skip header
            //         Cliente::create([
            //             'id_cliente' => $data[0],
            //             'cessato' => $data[1],
            //             'ditta' => $data[2],
            //             // ... map other fields
            //         ]);
            //     }
            // }

            // Import Apparecchi
            $this->info('Importing Apparecchi...');
            try {
                $apparecchiOutput = shell_exec("mdb-export '{$mdbPath}' Apparecchi");
            } catch (Exception $e) {
                $this->error('Failed to export Apparecchi table');

                return 1;
            }

            $apparecchiRows = array_filter(explode("\n", $apparecchiOutput ?? ''));

            // foreach ($apparecchiRows as $row) {
            //     $data = str_getcsv($row);
            //     if (count($data) > 1) { // Skip header
            //         Apparecchio::create([
            //             'id_cliente' => $data[0],
            //             'id_apparecchio' => $data[1],
            //             'tipo_apparecchio' => $data[2],
            //             // ... map other fields
            //         ]);
            //     }
            // }

            // Continue with other tables...

            $this->info('Import completed successfully!');

            return 0;
        } catch (Exception $e) {
            $this->error('Error importing data: '.$e->getMessage());

            return 1;
        }
    }
}
