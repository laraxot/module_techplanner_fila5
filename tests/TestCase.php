<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Tests;

use Illuminate\Database\Connection;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case for TechPlanner module tests.
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    /**
     * Connessione da riportare indietro dopo ogni test: quella predefinita (SQLite in `.env.testing`,
     * MariaDB in CI). Un nome fisso (`sqlite`) rompeva ogni test su MariaDB. `tech_planner` non si apre
     * qui: alcuni test la riconfigurano su SQLite in memoria e la connessione deve nascere dopo.
     *
     * @return list<string>
     */
    protected function connectionsToTransact()
    {
        $default = config('database.default');

        return array_values(array_unique(array_filter([\is_string($default) ? $default : null])));
    }

    /**
     * Porta la connessione `tech_planner` su un SQLite in memoria, solo per il test in corso.
     *
     * TenantServiceProvider risolve le connessioni dei moduli sulla connessione predefinita (una sola sessione,
     * transazioni atomiche tra moduli): per i test che costruiscono il proprio schema quell'alias va tolto,
     * altrimenti le tabelle finirebbero nel database condiviso.
     */
    public function useIsolatedTechPlannerConnection(bool $foreignKeys = false): void
    {
        config(['database.connections.tech_planner' => ['driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '', 'foreign_key_constraints' => $foreignKeys]]);
        DB::purge('tech_planner');
        DB::extend('tech_planner', static function (array $config, string $name): Connection {
            /** @var ConnectionFactory $factory */
            $factory = app('db.factory');

            return $factory->make($config, $name);
        });
    }
}
