<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\DeviceResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Schemas\Components\Component;
use Modules\TechPlanner\Filament\Resources\DeviceResource;
use Modules\TechPlanner\Filament\Resources\DeviceResource\Schemas\DeviceInfolist;
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

    /**
     * @return array<string, Component>
     */
    protected function getInfolistSchema(): array
    {
        return app(DeviceInfolist::class)->getInfolistSchema();
    }
}
