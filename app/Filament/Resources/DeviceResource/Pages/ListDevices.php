<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\DeviceResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ImportAction;
use Filament\Tables\Columns\TextColumn;
use Modules\TechPlanner\Filament\Imports\DeviceImporter;
use Modules\TechPlanner\Filament\Resources\DeviceResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListDevices extends XotBaseListRecords
{
    protected static string $resource = DeviceResource::class;

    #[Override]
    public function getHeaderActions(): array
    {
        /** @var array<string, Action> $actions */
        $actions = [
            ...parent::getHeaderActions(),
            ImportAction::make('importDevice')->importer(DeviceImporter::class),
        ];

        return $actions;
    }

    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable()
                ->searchable(),
            'client_id' => TextColumn::make('client_id')
                ->sortable()
                ->searchable(),
            'type' => TextColumn::make('type')
                ->sortable()
                ->searchable(),
            'brand' => TextColumn::make('brand')
                ->sortable()
                ->searchable(),
            'model' => TextColumn::make('model')
                ->sortable()
                ->searchable(),
            'headset_serial' => TextColumn::make('headset_serial')
                ->sortable()
                ->searchable(),
            'tube_serial' => TextColumn::make('tube_serial')
                ->sortable()
                ->searchable(),
            'kv' => TextColumn::make('kv')
                ->sortable()
                ->searchable(),
            'ma' => TextColumn::make('ma')
                ->sortable()
                ->searchable(),
            'first_verification_date' => TextColumn::make('first_verification_date')
                ->sortable()
                ->searchable(),
            'notes' => TextColumn::make('notes')
                ->sortable()
                ->searchable()
                ->wrap(),
        ];
    }
}
