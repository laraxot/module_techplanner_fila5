<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\DeviceResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ImportAction;
use Modules\TechPlanner\Filament\Imports\DeviceImporter;
use Modules\TechPlanner\Filament\Resources\DeviceResource;
use Modules\TechPlanner\Filament\Resources\DeviceResource\Tables\DevicesTable;
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
        return (new DevicesTable())->getTableColumns();
    }
}
