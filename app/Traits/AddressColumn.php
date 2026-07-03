<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Traits;

use Illuminate\Database\Schema\Blueprint;
use Modules\Geo\Enums\AddressItemEnum;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Trait for centralized address column management.
 *
 * This trait provides convenient methods for adding address columns
 * to database tables, following the DRY + KISS principles and
 * Laraxot migration philosophy.
 *
 * The trait acts as a semantic wrapper around AddressItemEnum::columns(),
 * providing clear intent and simplified usage in migrations.
 *
 * Usage in migrations:
 * ```php
 * use Modules\TechPlanner\Traits\AddressColumn;
 *
 * class CreateClientsTable extends XotBaseMigration
 * {
 *     public function up(): void
 *     {
 *         $this->tableCreate(function (Blueprint $table): void {
 *             $table->id();
 *             AddressColumn::add($table); // Standard address columns
 *             $table->timestamps();
 *         });
 *
 *         $this->tableUpdate(function (Blueprint $table): void {
 *             AddressColumn::add($table, $this); // With migration context
 *         });
 *     }
 * }
 * ```
 */
trait AddressColumn
{
    /**
     * Add standard address columns to a table.
     *
     * This is the preferred method for adding address columns.
     * It includes all core address fields (route, locality, country, etc.)
     * plus geocoding fields (latitude, longitude, place_id).
     *
     * @param  Blueprint  $table  The table blueprint
     * @param  XotBaseMigration|null  $migration  Migration instance for UPDATE context
     */
    public static function add(Blueprint $table, ?XotBaseMigration $migration = null): void
    {
        AddressItemEnum::columns($table, $migration, false);
    }

    /**
     * Add full address columns including legacy compatibility.
     *
     * Use this method when you need to maintain compatibility with
     * legacy code that expects generic field names like 'address',
     * 'city', 'province', etc.
     *
     * @param  Blueprint  $table  The table blueprint
     * @param  XotBaseMigration|null  $migration  Migration instance for UPDATE context
     */
    public static function addWithLegacy(Blueprint $table, ?XotBaseMigration $migration = null): void
    {
        AddressItemEnum::columns($table, $migration, true);
    }

    /**
     * Update existing table with missing address columns.
     *
     * This method is specifically for UPDATE blocks in migrations.
     * It checks for column existence before adding, following Laraxot patterns.
     *
     * @param  Blueprint  $table  The table blueprint
     * @param  XotBaseMigration  $migration  Migration instance for column checks
     * @param  bool  $withLegacy  Whether to include legacy fields
     */
    public static function update(Blueprint $table, XotBaseMigration $migration, bool $withLegacy = false): void
    {
        AddressItemEnum::updateColumns($table, $migration, $withLegacy);
    }

    /**
     * Drop all address columns from a table.
     *
     * Use this method in rollback migrations to cleanly remove
     * all address-related columns.
     *
     * @param  Blueprint  $table  The table blueprint
     */
    public static function drop(Blueprint $table): void
    {
        AddressItemEnum::dropColumns($table);
    }

    /**
     * Get all address column names.
     *
     * Useful for validation, debugging, or dynamic queries.
     *
     * @return array<int, string> List of column names
     */
    public static function getColumnNames(): array
    {
        return AddressItemEnum::getColumnNames();
    }
}
