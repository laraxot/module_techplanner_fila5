<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Imports;

use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Modules\TechPlanner\Models\MedicalDirector;

class MedicalDirectorImporter extends Importer
{
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
        // return MedicalDirector::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new MedicalDirector();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body =
            'Your client import has completed and '.
            number_format($import->successful_rows).
            ' '.
            str('row')->plural($import->successful_rows).
            ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .=
                ' '.
                number_format($failedRowsCount).
                ' '.
                str('row')->plural($failedRowsCount).
                ' failed to import.';
        }

        return $body;
    }
}
