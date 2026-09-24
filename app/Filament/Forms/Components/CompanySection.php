<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Forms\Components;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Modules\TechPlanner\Enums\CompanyItemEnum;
use Modules\Xot\Filament\Schemas\Components\XotBaseSection;

/**
 * CompanySection - Sezione Form per dati aziendali
 *
 * Componente specializzato per la gestione dei dati aziendali nel dominio TechPlanner.
 * Segue il pattern enum-driven per coerenza architetturale con AddressSection e ContactSection.
 *
 * Caratteristiche:
 * - Campi centralizzati in CompanyItemEnum
 * - Layout a 2 colonne per ottimizzazione spazio
 * - Validazioni business-specifiche italiane
 * - Internationalizzazione completa
 *
 * @see CompanyItemEnum Per definizione campi e traduzioni
 */
class CompanySection extends XotBaseSection
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->schema(fn (): array => $this->getFormSchema());
        $this->columns(2);
    }

    /**
     * Schema dei campi aziendali centralizzato.
     *
     * Utilizza CompanyItemEnum::getFormSchema() per garantire:
     * - Single source of truth per definizioni campi
     * - Traduzioni automatiche
     * - Icone e colori consistenti
     * - Manutenzione semplificata
     *
     * @return array<string, TextInput|Toggle>
     */
    protected function getFormSchema(): array
    {
        return CompanyItemEnum::getFormSchema();
    }
}
