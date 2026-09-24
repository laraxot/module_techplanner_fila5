<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\PhoneCallResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\TechPlanner\Filament\Resources\PhoneCallResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditPhoneCall extends XotBaseEditRecord
{
    protected static string $resource = PhoneCallResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
