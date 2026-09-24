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
            $table->foreignId('device_id')->constrained('machines')->cascadeOnDelete();
            $table->date('verification_date')->index();
            $table->date('next_verification_date')->index();
            $table->string('result')->index();
            $table->string('exposure_parameters');
            $table->string('verification_type')->index();
            $table->text('notes')->nullable();
        });

        $this->tableUpdate(function (Blueprint $table): void {
            $this->updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );
        });
    }
};
