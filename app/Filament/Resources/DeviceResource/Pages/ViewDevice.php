<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\DeviceResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Modules\TechPlanner\Filament\Resources\DeviceResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewDevice extends XotBaseViewRecord
{
    protected static string $resource = DeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'edit' => EditAction::make(),
            'delete' => DeleteAction::make(),
        ];
    }
}
