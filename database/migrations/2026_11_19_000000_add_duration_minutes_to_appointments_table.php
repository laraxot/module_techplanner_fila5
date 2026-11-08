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
            if (! $this->hasColumn('duration_minutes')) {
                $table->unsignedSmallInteger('duration_minutes')->default(60)->after('date');
            }
        });
    }
};
