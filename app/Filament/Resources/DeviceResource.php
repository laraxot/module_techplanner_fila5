<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources;

use Modules\TechPlanner\Filament\Resources\DeviceResource\Pages\CreateDevice;
use Modules\TechPlanner\Filament\Resources\DeviceResource\Pages\EditDevice;
use Modules\TechPlanner\Filament\Resources\DeviceResource\Pages\ListDevices;
use Modules\TechPlanner\Filament\Resources\DeviceResource\Pages\ViewDevice;
use Modules\TechPlanner\Filament\Resources\DeviceResource\Schemas\DeviceForm;
use Modules\TechPlanner\Filament\Resources\DeviceResource\Schemas\DeviceInfolist;
use Modules\TechPlanner\Filament\Resources\RelationManagers\DeviceVerificationsRelationManager;
use Modules\TechPlanner\Models\Device;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class DeviceResource extends XotBaseResource
{
    protected static ?string $model = Device::class;

    #[Override]
    public static function getFormSchema(): array
    {
        return DeviceForm::getFormSchema();
    }

    #[Override]
    public static function getInfolistSchema(): array
    {
        return DeviceInfolist::getInfolistSchema();
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListDevices::route('/'),
            'create' => CreateDevice::route('/create'),
            'view' => ViewDevice::route('/{record}'),
            'edit' => EditDevice::route('/{record}/edit'),
        ];
    }

    #[Override]
    public static function getRelations(): array
    {
        return [
            DeviceVerificationsRelationManager::class,
        ];
    }
}
