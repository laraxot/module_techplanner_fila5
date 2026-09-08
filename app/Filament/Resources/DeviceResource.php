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

   
}
