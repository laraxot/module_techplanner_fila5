<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Geo\Enums\AddressItemEnum;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class() extends XotBaseMigration
{
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            // name viene aggiunto da AddressItemEnum::columns() come "Location name"
            // company_name viene aggiunto nel blocco UPDATE per il nome aziendale
            $table->string('vat_number')->nullable();
            $table->string('fiscal_code')->nullable();

            // Standard address columns via AddressItemEnum::columns()
            // DRY + KISS pattern inspired by laravel-nestedset and workers_table migration
            // null = CREATE context (no hasColumn checks), true = include legacy fields
            AddressItemEnum::columnsWithLegacy($table, null);

            $this->addCommonFields($table);
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            // name è gestito da AddressItemEnum::columns() come "Location name"

            // Business fields
            if (! $this->hasColumn('business_closed')) {
                $table->boolean('business_closed')->default(false);
            }
            if (! $this->hasColumn('competent_health_unit')) {
                $table->string('competent_health_unit')->nullable()->comment('Az ULSS competente');
            }
            if (! $this->hasColumn('vat_number')) {
                $table->string('vat_number')->nullable()->comment('Partita IVA');
            }
            if (! $this->hasColumn('tax_code')) {
                $table->string('tax_code')->nullable()->comment('Codice fiscale');
            }
            if (! $this->hasColumn('company_name')) {
                $table->string('company_name')->nullable()->comment('Ragione sociale');
            }
            if (! $this->hasColumn('company_office')) {
                $table->string('company_office')->nullable()->comment('Sede ditta');
            }
            if (! $this->hasColumn('activity')) {
                $table->string('activity')->nullable()->comment('Attività');
            }

            // Address columns: ensure all standard AddressItemEnum fields exist
            // Following Laraxot pattern from workers_table migration with hasColumn() checks
            // $this = UPDATE context (uses hasColumn), true = include legacy fields
            AddressItemEnum::columnsWithLegacy($table, $this);

            $this->updateTimestamps($table, true);
        });
    }
};
