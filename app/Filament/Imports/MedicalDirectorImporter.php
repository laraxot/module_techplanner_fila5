<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Imports;

use Filament\Actions\Imports\ImportColumn;
use Modules\TechPlanner\Filament\Imports\Concerns\ResolvesExistingRecord;
use Modules\TechPlanner\Models\MedicalDirector;
use Modules\Xot\Filament\Actions\Imports\XotBaseImporter;

class MedicalDirectorImporter extends XotBaseImporter
{
    use ResolvesExistingRecord;

    protected static ?string $model = MedicalDirector::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('id'), // id
            ImportColumn::make('client_id'), // IDCliente
            ImportColumn::make('last_name'), // Cognome
            ImportColumn::make('first_name'), // Nome
            ImportColumn::make('residence'), // Residenza
            ImportColumn::make('address'), // Indirizzo
            ImportColumn::make('street_number'), // N° civico
            ImportColumn::make('province'), // Prov
            ImportColumn::make('birth_place'), // nato a
            ImportColumn::make('birth_date'), // Data nascita
            ImportColumn::make('start_date'), // Data inizio
            ImportColumn::make('end_date'), // Data fine
        ];
    }

    public function resolveRecord(): ?MedicalDirector
    {
        $record = $this->resolveExistingRecord();

        return $record instanceof MedicalDirector ? $record : new MedicalDirector();
    }

    /**
     * @return list<string>
     */
    protected function matchingKeys(): array
    {
        return ['id'];
    }
}
