<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\TechPlanner\Models\Device;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class() extends XotBaseMigration
{
    public function up(): void
    {
        /*
         * Gli apparecchi stanno nella tabella del modello Device (`machines`, condivisa con Machine
         * che estende Device): il nome si legge dal modello, non si ripete a mano.
         */
        $devicesTable = (new Device())->getTable();

        $this->tableCreate(function (Blueprint $table) use ($devicesTable): void {
            $table->bigIncrements('id');
            $table->foreignIdFor(Device::class)->constrained($devicesTable)->cascadeOnDelete();
            $table->date('verification_date')->index();
            $table->date('next_verification_date')->index();
            $table->string('result')->index();
            $table->string('exposure_parameters')->nullable();
            $table->string('verification_type')->index();
            $table->text('notes')->nullable();
        });

        $this->tableUpdate(function (Blueprint $table): void {
            // Era NOT NULL senza un campo nel form: nessuna verifica si poteva salvare (2026-11-05).
            if ($this->hasColumn('exposure_parameters')) {
                $table->string('exposure_parameters')->nullable()->change();
            }

            $this->updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );
        });
    }
};
