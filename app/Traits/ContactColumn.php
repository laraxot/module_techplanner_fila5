<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Traits;

use Filament\Forms\Components\TextInput;
use Illuminate\Database\Schema\Blueprint;
use Modules\Notify\Enums\ContactTypeEnum;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Trait for centralized contact column management.
 *
 * This trait provides convenient methods for adding contact columns
 * to database tables, following the DRY + KISS principles and
 * Laraxot migration philosophy.
 *
 * The trait acts as a semantic wrapper around ContactTypeEnum::columns(),
 * providing clear intent and simplified usage in migrations.
 *
 * Usage in migrations:
 * ```php
 * use Modules\TechPlanner\Traits\ContactColumn;
 *
 * class CreateClientsTable extends XotBaseMigration
 * {
 *     public function up(): void
 *     {
 *         $this->tableCreate(function (Blueprint $table): void {
 *             $table->id();
 *             ContactColumn::add($table); // Standard contact columns
 *             $table->timestamps();
 *         });
 *
 *         $this->tableUpdate(function (Blueprint $table): void {
 *             ContactColumn::add($table, $this); // With migration context
 *         });
 *     }
 * }
 * ```
 */
trait ContactColumn
{
    /**
     * Add standard contact columns to a table.
     *
     * This method adds all core contact fields:
     * - phone, mobile, email, pec
     * - whatsapp, fax, notes
     *
     * @param  Blueprint  $table  The table blueprint
     * @param  XotBaseMigration|null  $migration  Migration instance for UPDATE context
     */
    public static function add(Blueprint $table, ?XotBaseMigration $migration = null): void
    {
        ContactTypeEnum::columns($table, $migration);
    }

    /**
     * Update existing table with missing contact columns.
     *
     * This method is specifically for UPDATE blocks in migrations.
     * It checks for column existence before adding, following Laraxot patterns.
     *
     * @param  Blueprint  $table  The table blueprint
     * @param  XotBaseMigration  $migration  Migration instance for column checks
     */
    public static function update(Blueprint $table, XotBaseMigration $migration): void
    {
        ContactTypeEnum::updateColumns($table, $migration);
    }

    /**
     * Drop all contact columns from a table.
     *
     * Use this method in rollback migrations to cleanly remove
     * all contact-related columns.
     *
     * @param  Blueprint  $table  The table blueprint
     */
    public static function drop(Blueprint $table): void
    {
        ContactTypeEnum::dropColumns($table);
    }

    /**
     * Get all contact column names.
     *
     * Useful for validation, debugging, or dynamic queries.
     *
     * @return array<int, string> List of column names
     */
    public static function getColumnNames(): array
    {
        return ContactTypeEnum::getColumnNames();
    }

    /**
     * Get contact form schema for Filament forms.
     *
     * Provides a ready-to-use form schema with all contact fields,
     * complete with icons and proper configuration.
     *
     * @return array<string, TextInput>
     */
    public static function getFormSchema(): array
    {
        return ContactTypeEnum::getFormSchema();
    }
}
