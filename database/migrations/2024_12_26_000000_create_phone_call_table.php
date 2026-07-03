<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
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
            $table->datetime('date');
            $table->integer('duration')->nullable(); // Durata in secondi
            $table->text('notes')->nullable();
            $table->enum('call_type', ['inbound', 'outbound']);
            $this->addCommonFields($table);
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            // Aggiungere colonna client_id se non esiste
            if (! $this->hasColumn('client_id')) {
                $table->unsignedBigInteger('client_id')->nullable()->index();
            }

            // Aggiungere foreign key constraint solo se la tabella clients esiste
            // Se la foreign key esiste già, MySQL genererà un errore che possiamo ignorare
            if ($this->hasTable('clients')) {
                try {
                    $table->foreign('client_id')
                        ->references('id')
                        ->on('clients')
                        ->onDelete('cascade');
                } catch (\Exception $e) {
                    // Foreign key potrebbe esistere già, ignora l'errore
                    // Questo può accadere se la migrazione viene eseguita più volte
                }
            }

            $this->updateTimestamps($table, true);
        });
    }
};
