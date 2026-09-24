<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Class CreateWorkersTable.
 */
return new class() extends XotBaseMigration
{
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('status')->nullable();
            $table->text('notes')->nullable();
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('client_id')) {
                $table->integer('client_id')->index()->nullable();
            }

            if (! $this->hasColumn('appointment_id')) {
                $table->integer('appointment_id')->index()->nullable();
            }

            if ($this->hasColumn('status')) {
                $table->string('status')->nullable()->change();
            } else {
                $table->string('status')->nullable();
            }

            $this->updateTimestamps($table, true);
        });
    }
};
