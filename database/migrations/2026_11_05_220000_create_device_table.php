<?php

declare(strict_types=1);

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class() extends XotBaseMigration
{
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            // Creare solo la colonna senza foreign key constraint
            // La foreign key verrà aggiunta nel blocco UPDATE se la tabella clients esiste
            $table->unsignedBigInteger('client_id')->nullable()->index();
            $table->string('name')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('inventory_number')->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('warranty_expiration')->nullable();
            $table->text('notes')->nullable();
            $this->addCommonFields($table);
        });
        // -- UPDATE --
        /*
         * `client_id` nasce `integer` nella migrazione 2019 delle macchine: MySQL rifiuta una FK
         * int -> bigint unsigned (errno 150). Prima si allinea il tipo, in un passaggio separato,
         * poi si aggiunge il vincolo. Verificato su MariaDB 10.11 il 2026-11-10.
         */
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('client_id')) {
                $table->unsignedBigInteger('client_id')->nullable()->index();
            } elseif ($this->driver() !== 'sqlite' && ! $this->isColumnType('client_id', 'bigint')) {
                $table->unsignedBigInteger('client_id')->nullable()->change();
            }
        });

        $this->tableUpdate(function (Blueprint $table): void {

            /*
             * FK verso clients solo se manca. Il vecchio try/catch non proteggeva nulla: Blueprint
             * esegue i comandi dopo la closure, quindi al secondo giro MySQL falliva per vincolo
             * duplicato. Ora la migrazione si può rieseguire (regola 009: rename = rerun).
             */
            $hasClientForeignKey = array_filter(
                $this->getConn()->getForeignKeys($this->getTable()),
                static fn (array $fk): bool => $fk['columns'] === ['client_id'],
            ) !== [];
            // Righe che puntano a clienti inesistenti (dati importati) farebbero fallire il vincolo
            // e con lui il rilascio: in quel caso il vincolo si rimanda, i dati restano intatti.
            $hasOrphans = $this->hasTable('clients') && DB::connection($this->getConnection())->table($this->getTable())
                ->whereNotNull('client_id')
                ->whereNotIn('client_id', static fn (QueryBuilder $query): QueryBuilder => $query->select('id')->from('clients'))
                ->exists();
            if ($this->hasTable('clients') && ! $hasClientForeignKey && ! $hasOrphans) {
                $table->foreign('client_id')
                    ->references('id')
                    ->on('clients')
                    ->onDelete('cascade');
            }
            $table->string('name')->nullable()->change();
            /*
             * La tabella `machines` nasce (2019) per le macchine di un appuntamento, con
             * `appointment_id` obbligatorio. Un apparecchio registrato dal cliente non ha
             * appuntamento: senza questo change nessun apparecchio si poteva salvare (2026-11-05).
             */
            if ($this->hasColumn('appointment_id')) {
                $table->unsignedBigInteger('appointment_id')->nullable()->change();
            }
            if (! $this->hasColumn('type')) {
                $table->string('type')->nullable();
            }
            if (! $this->hasColumn('brand')) {
                $table->string('brand')->nullable();
            }
            if (! $this->hasColumn('model')) {
                $table->string('model')->nullable();
            }
            if (! $this->hasColumn('headset_serial')) {
                $table->string('headset_serial')->nullable();
            }
            if (! $this->hasColumn('tube_serial')) {
                $table->string('tube_serial')->nullable();
            }
            if (! $this->hasColumn('kv')) {
                $table->decimal('kv', 5, 2)->nullable();
            }
            if (! $this->hasColumn('ma')) {
                $table->decimal('ma', 5, 2)->nullable();
            }
            if (! $this->hasColumn('serial_number')) {
                $table->string('serial_number')->nullable();
            }
            if (! $this->hasColumn('inventory_number')) {
                $table->string('inventory_number')->nullable();
            }
            if (! $this->hasColumn('purchase_date')) {
                $table->date('purchase_date')->nullable();
            }
            if (! $this->hasColumn('first_verification_date')) {
                $table->date('first_verification_date')->nullable();
            }
            if (! $this->hasColumn('warranty_expiration')) {
                $table->date('warranty_expiration')->nullable();
            }
            if (! $this->hasColumn('notes')) {
                $table->text('notes')->nullable();
            }
            // $this->updateCommonFields($table);
            $this->updateTimestamps($table, true);
        });
    }
};
