<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Imports;

use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Modules\TechPlanner\Models\Device;

class DeviceImporter extends Importer
{
    protected static ?string $model = Device::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('id'), // id
            ImportColumn::make('client_id'), // IDCliente
            ImportColumn::make('type'), // TipoApparecchio
            ImportColumn::make('brand'), // Marca
            ImportColumn::make('model'), // Modello
            ImportColumn::make('headset_serial'), // Matricola Cuffia
            ImportColumn::make('tube_serial'), // Matricola Tubo
            ImportColumn::make('kv'), // KV
            ImportColumn::make('ma'), // ma
            ImportColumn::make('first_verification_date'), // DataPrimaVerifica
            ImportColumn::make('notes'), // Commenti
        ];
    }

    public function resolveRecord(): ?Device
    {
        // return Device::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Device();
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
