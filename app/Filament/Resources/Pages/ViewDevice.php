<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\Pages;

use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Modules\TechPlanner\Filament\Resources\DeviceResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Override;

class ViewDevice extends XotBaseViewRecord
{
    protected static string $resource = DeviceResource::class;

   
}
