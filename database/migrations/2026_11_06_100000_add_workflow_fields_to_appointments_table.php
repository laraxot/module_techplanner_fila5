<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\TechPlanner\Models\Appointment;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class() extends XotBaseMigration
{
    protected ?string $model_class = Appointment::class;

    public function up(): void
    {
        $this->tableUpdate(function (Blueprint $table): void {
            // `workers` è una tabella legacy senza migration nel repo: solo indice, niente FK.
            if (! $this->hasColumn('worker_id')) {
                $table->unsignedInteger('worker_id')->nullable()->index();
            }
            if (! $this->hasColumn('status')) {
                $table->string('status')->nullable()->index();
            }
            if (! $this->hasColumn('outcome')) {
                $table->text('outcome')->nullable();
            }
            if (! $this->hasColumn('reminder_sent_at')) {
                $table->timestamp('reminder_sent_at')->nullable();
            }
        });
    }
};
