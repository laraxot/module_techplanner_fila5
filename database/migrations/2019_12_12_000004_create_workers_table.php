<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Geo\Models\Place;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Class CreateWorkersTable.
 */
return new class() extends XotBaseMigration
{
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->nullable();
            $table->integer('client_id')->nullable()->index();
            $table->string('last_name', 50)->nullable();
            $table->string('first_name', 50)->nullable();
            $table->string('birth_place', 50)->nullable();
            $table->date('birth_day')->nullable();
            $table->dateTime('date_start')->nullable();
            $table->dateTime('date_end')->nullable();
            $table->text('address')->nullable();
            $table->text('note')->nullable();
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            $address_components = Place::$address_components;
            foreach ($address_components as $el) {
                if (! $this->hasColumn($el)) {
                    $table->string($el)->nullable();
                }
                if (! $this->hasColumn($el.'_short')) {
                    $table->string($el.'_short')->nullable();
                }
            }
            if (! $this->hasColumn('phone')) {
                $table->string('phone')->nullable();
            }
            if (! $this->hasColumn('website')) {
                $table->string('website')->nullable();
            }
            if (! $this->hasColumn('email')) {
                $table->string('email')->nullable();
            }

            if (! $this->hasColumn('address')) {
                $table->text('address')->nullable();
            }

            if (! $this->hasColumn('formatted_address')) {
                $table->string('formatted_address')->nullable();
            }
            if (! $this->hasColumn('latitude')) {
                $table->decimal('latitude', 11, 8)->nullable();
            }
            if (! $this->hasColumn('longitude')) {
                $table->decimal('longitude', 11, 8)->nullable();
            }

            if (! $this->hasColumn('full_name')) {
                $table->string('full_name')->nullable()->after('first_name');
            }

            if (! $this->hasColumn('p_iva')) {
                $table->string('p_iva')->nullable();
            }

            if (! $this->hasColumn('cod_fisc')) {
                $table->string('cod_fisc')->nullable();
            }

            if (! $this->hasColumn('full_address')) {
                $table->text('full_address')->nullable()->after('address');
            }
            $this->updateTimestamps($table, true);
        });
    }
};
