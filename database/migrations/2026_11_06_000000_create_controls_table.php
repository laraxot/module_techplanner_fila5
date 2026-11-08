<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class() extends XotBaseMigration
{
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->foreignId('client_id')->nullable()->constrained('clients')->cascadeOnDelete();
            $table->foreignId('device_id')->nullable()->constrained('machines')->nullOnDelete();
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->nullOnDelete();
            // `workers` è una tabella legacy senza migration nel repo: niente FK, solo indice.
            $table->unsignedInteger('worker_id')->nullable()->index();
            $table->string('control_type')->index();
            $table->string('status')->nullable()->index();
            $table->text('result')->nullable();
            $table->date('control_date')->nullable()->index();
            $table->date('next_control_date')->nullable()->index();
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable();
        });

        $this->tableUpdate(function (Blueprint $table): void {
            $this->updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );
        });
    }
};
