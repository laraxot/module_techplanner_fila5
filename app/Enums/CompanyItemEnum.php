<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Enums;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Modules\Xot\Filament\Traits\TransTrait;

/**
 * Enum per i campi aziendali del dominio TechPlanner.
 *
 * Questo enum centralizza la definizione di tutti i campi relativi alle informazioni
 * aziendali, seguendo i principi DRY e KISS nel contesto del business italiano.
 *
 * Definisce:
 * - Label tradotti in tutte le lingue supportate (en, it, de, fr, es)
 * - Icone Heroicon per ogni campo
 * - Colori per categorizzazione visiva
 * - Descrizioni contestuali per il business italiano
 *
 * Ogni valore rappresenta un **componente atomico** dei dati aziendali:
 * - Informazioni anagrafiche (company_name)
 * - Dati fiscali (vat_number, tax_code, fiscal_code)
 * - Stato operativo (business_closed)
 * - Settore merceologico (activity)
 */
enum CompanyItemEnum: string implements HasColor, HasIcon, HasLabel
{
    use TransTrait;

    case BUSINESS_CLOSED = 'business_closed';
    case ACTIVITY = 'activity';
    case COMPANY_NAME = 'company_name';
    case TAX_CODE = 'tax_code';
    case VAT_NUMBER = 'vat_number';
    case FISCAL_CODE = 'fiscal_code';

    public function getLabel(): string
    {
        return $this->transClass(self::class, $this->value.'.label');
    }

    public function getColor(): string
    {
        return $this->transClass(self::class, $this->value.'.color');
    }

    public function getIcon(): string
    {
        return $this->transClass(self::class, $this->value.'.icon');
    }

    public function getDescription(): string
    {
        return $this->transClass(self::class, $this->value.'.description');
    }

    /**
     * @return array<string>
     */
    public static function getSearchable(): array
    {
        return array_map(fn (self $item) => $item->value, self::cases());
    }

    /**
     * @return array<string, TextInput|Toggle>
     */
    public static function getFormSchema(): array
    {
        $cases = self::cases();
        /** @var array<string, TextInput|Toggle> $result */
        $result = [];

        foreach ($cases as $item) {
            $fieldName = $item->value;
            $label = $item->getLabel();
            $icon = $item->getIcon();
            $isRequired = $item === self::COMPANY_NAME;

            if ($item === self::BUSINESS_CLOSED) {
                $result[$fieldName] = Toggle::make($fieldName)
                    ->label($label);
            } else {
                $input = TextInput::make($fieldName)
                    ->label($label)
                    ->prefixIcon($icon);

                if ($isRequired) {
                    $input->required();
                } else {
                    $input->nullable();
                }

                $result[$fieldName] = $input;
            }
        }

        return $result;
    }

    /**
     * Add all standard company columns to a migration table.
     *
     * Following the philosophy of AddressItemEnum::columns() and ContactTypeEnum::columns(),
     * this method provides centralized column definitions for company-related fields.
     *
     * The method handles both CREATE and UPDATE contexts:
     * - **CREATE context** ($migration = null): Adds all columns directly
     * - **UPDATE context** ($migration provided): Checks column existence before adding
     *
     * Usage in migrations:
     * ```php
     * // In CREATE block:
     * $this->tableCreate(function (Blueprint $table): void {
     *     $table->id();
     *     CompanyItemEnum::columns($table); // migration = null, adds all
     * });
     *
     * // In UPDATE block:
     * $this->tableUpdate(function (Blueprint $table): void {
     *     CompanyItemEnum::columns($table, $this); // loops with checks
     * });
     * ```
     *
     * @param  Blueprint  $table  The table blueprint
     * @param  XotBaseMigration|null  $migration  XotBaseMigration instance for UPDATE context
     */
    public static function columns(Blueprint $table, ?XotBaseMigration $migration = null): void
    {
        // Colonne aziendali - aggiungi con check solo se in UPDATE context
        foreach (self::getColumnDefinitions() as $name => $definition) {
            if ($migration === null || ! $migration->hasColumn($name)) {
                $definition($table);
            }
        }
    }

    /**
     * Ensure all standard company columns exist in UPDATE context.
     *
     * Thin wrapper around columns() for semantic clarity in migrations:
     *
     * ```php
     * $this->tableUpdate(function (Blueprint $table): void {
     *     CompanyItemEnum::updateColumns($table, $this);
     * });
     * ```
     */
    public static function updateColumns(Blueprint $table, XotBaseMigration $migration): void
    {
        self::columns($table, $migration);
    }

    /**
     * Drop all standard company columns from a table.
     *
     * Usage in rollback migrations:
     * ```php
     * CompanyItemEnum::dropColumns($table);
     * ```
     *
     * @param  Blueprint  $table  The table blueprint
     */
    public static function dropColumns(Blueprint $table): void
    {
        $table->dropColumn(self::getColumnNames());
    }

    /**
     * Get all column names as an array.
     *
     * @return array<int, string>
     */
    public static function getColumnNames(): array
    {
        return array_map(fn (self $item) => $item->value, self::cases());
    }

    /**
     * Internal map of standard company column definitions.
     *
     * @return array<string, callable(Blueprint): void>
     */
    private static function getColumnDefinitions(): array
    {
        return [
            self::BUSINESS_CLOSED->value => static function (Blueprint $table): void {
                $table->boolean(self::BUSINESS_CLOSED->value)
                    ->default(false)
                    ->comment('Business closed status');
            },
            self::ACTIVITY->value => static function (Blueprint $table): void {
                $table->string(self::ACTIVITY->value)
                    ->nullable()
                    ->comment('Business activity sector');
            },
            self::COMPANY_NAME->value => static function (Blueprint $table): void {
                $table->string(self::COMPANY_NAME->value)
                    ->comment('Company legal name');
            },
            self::TAX_CODE->value => static function (Blueprint $table): void {
                $table->string(self::TAX_CODE->value)
                    ->nullable()
                    ->comment('Tax code for business');
            },
            self::VAT_NUMBER->value => static function (Blueprint $table): void {
                $table->string(self::VAT_NUMBER->value)
                    ->nullable()
                    ->comment('VAT number (Partita IVA)');
            },
            self::FISCAL_CODE->value => static function (Blueprint $table): void {
                $table->string(self::FISCAL_CODE->value)
                    ->nullable()
                    ->comment('Fiscal code');
            },
        ];
    }
}
