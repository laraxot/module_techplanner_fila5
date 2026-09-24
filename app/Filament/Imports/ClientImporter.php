<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Imports;

use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Models\Import;
use Modules\TechPlanner\Models\Client;
use Modules\Xot\Filament\Actions\Imports\XotBaseImporter;

class ClientImporter extends XotBaseImporter
{
    protected static ?string $model = Client::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('id'), // id
            ImportColumn::make('business_closed'), // cessato
            ImportColumn::make('company_name'), // ditta
            ImportColumn::make('competent_health_unit'), // az_ulss_competente
            ImportColumn::make('tax_code'), // cf
            ImportColumn::make('vat_number'), // partita_iva
            ImportColumn::make('company_office'), // sede_ditta
            ImportColumn::make('address'), // indirizzo
            ImportColumn::make('street_number'), // numero_civico
            ImportColumn::make('province'), // provincia
            ImportColumn::make('postal_code'), // cap
            ImportColumn::make('phone'), // telefono
            ImportColumn::make('fax'), // fax
            ImportColumn::make('mobile'), // cellulare
            ImportColumn::make('email'), // email
            ImportColumn::make('notes'), // note
            ImportColumn::make('activity'), // attivita
        ];
    }

    public function resolveRecord(): ?Client
    {
        // return Client::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Client();
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
