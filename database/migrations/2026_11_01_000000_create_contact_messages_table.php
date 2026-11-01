<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\TechPlanner\Models\ContactMessage;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Messaggi del form di contatto del sito. Solo in avanti: nessun drop, nessuna cancellazione di dati.
 * La conservazione (periodo di purge) e' una decisione del titolare e vive in config, non qui.
 */
return new class() extends XotBaseMigration
{
    protected ?string $model_class = ContactMessage::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('name', 120);
            $table->string('email', 190);
            $table->string('phone', 40)->nullable();
            $table->string('studio', 150)->nullable();
            $table->string('type', 100)->nullable();
            $table->text('message');
            $table->string('locale', 5);
            $table->string('status', 20)->index();
            $table->timestamp('privacy_accepted_at');
            $table->timestamp('forwarded_at')->nullable();
        });

        $this->tableUpdate(function (Blueprint $table): void {
            $this->updateTimestamps($table, false);
        });
    }
};
