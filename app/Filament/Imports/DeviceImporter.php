<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Imports;

use Filament\Actions\Imports\ImportColumn;
use Modules\TechPlanner\Filament\Imports\Concerns\ResolvesExistingRecord;
use Modules\TechPlanner\Models\Device;
use Modules\Xot\Filament\Actions\Imports\XotBaseImporter;

class DeviceImporter extends XotBaseImporter
{
    use ResolvesExistingRecord;

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
        $record = $this->resolveExistingRecord();

        return $record instanceof Device ? $record : new Device();
    }

    /**
     * @return list<string>
     */
    protected function matchingKeys(): array
    {
        return ['id'];
    }
}
