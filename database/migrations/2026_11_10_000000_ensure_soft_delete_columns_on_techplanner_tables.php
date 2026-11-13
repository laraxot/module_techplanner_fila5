<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * TPL-03: i modelli TechPlanner usano SoftDeletes da 2026-11-10. Le migrazioni di creazione aggiungono
 * `deleted_at` / `deleted_by` (updateTimestamps(..., true)), ma un database creato con versioni più vecchie
 * potrebbe non averle: ogni elenco andrebbe in errore su `where deleted_at is null`.
 *
 * Migrazione semplice (non XotBaseMigration) perché tocca più tabelle e nessun modello in particolare;
 * idempotente: aggiunge solo le colonne che mancano, sulle tabelle che esistono. Il down() non toglie nulla:
 * le colonne possono essere state create dalle migrazioni di creazione.
 */
return new class() extends Migration
{
    /** Tabelle dei modelli con SoftDeletes (Device e Machine condividono `machines`). */
    private const array TABLES = [
        'clients',
        'machines',
        'device_verifications',
        'appointments',
        'phone_calls',
        'medical_directors',
        'legal_representatives',
        'legal_offices',
        'workers',
    ];

    public function up(): void
    {
        foreach (self::TABLES as $table) {
            foreach ($this->connections() as $connection) {
                $schema = Schema::connection($connection);
                if (! $schema->hasTable($table)) {
                    continue;
                }

                $missingDeletedAt = ! $schema->hasColumn($table, 'deleted_at');
                $missingDeletedBy = ! $schema->hasColumn($table, 'deleted_by');
                if (! $missingDeletedAt && ! $missingDeletedBy) {
                    continue;
                }

                $schema->table($table, static function (Blueprint $blueprint) use ($missingDeletedAt, $missingDeletedBy): void {
                    if ($missingDeletedAt) {
                        $blueprint->softDeletes();
                    }
                    if ($missingDeletedBy) {
                        $blueprint->string('deleted_by', 36)->nullable();
                    }
                });
            }
        }
    }

    public function down(): void
    {
        // Volutamente vuoto: vedi commento in testa.
    }

    /**
     * La connessione del modulo e quella predefinita (in produzione di solito sono lo stesso database).
     *
     * @return list<string>
     */
    private function connections(): array
    {
        $names = [];
        $connections = config('database.connections');
        if (is_array($connections) && array_key_exists('tech_planner', $connections)) {
            $names[] = 'tech_planner';
        }
        $default = config('database.default');
        if (is_string($default) && ! in_array($default, $names, true)) {
            $names[] = $default;
        }

        return $names;
    }
};
