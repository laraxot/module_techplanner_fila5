<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class() extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->string('name')->index();
            $table->string('fiscal_code')->nullable()->index();
            $table->string('phone')->nullable();
            $table->string('email')->nullable()->index();
            $table->text('notes')->nullable();
        });

        // -- UPDATE --
        /*
         * Form, import CSV/Access e modello usavano tre insiemi di colonne diversi: salvare un
         * direttore dal pannello falliva (license_number, specialization, license_expiry assenti) e
         * l'import falliva su `name` obbligatorio (2026-11-05). Si aggiungono le colonne mancanti,
         * tutte facoltative: nessun dato esistente viene toccato.
         */
        $this->tableUpdate(function (Blueprint $table): void {
            if ($this->hasColumn('name')) {
                $table->string('name')->nullable()->change();
            }
            foreach (['last_name', 'first_name', 'residence', 'address', 'street_number', 'province', 'birth_place', 'license_number', 'specialization'] as $column) {
                if (! $this->hasColumn($column)) {
                    $table->string($column)->nullable();
                }
            }
            foreach (['birth_date', 'start_date', 'end_date', 'license_expiry'] as $column) {
                if (! $this->hasColumn($column)) {
                    $table->date($column)->nullable();
                }
            }

            $this->updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );
        });
    }
};
