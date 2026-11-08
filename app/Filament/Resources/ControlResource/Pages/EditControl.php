<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ControlResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\TechPlanner\Filament\Resources\ControlResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditControl extends XotBaseEditRecord
{
    protected static string $resource = ControlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
