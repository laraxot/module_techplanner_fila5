<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\TechPlanner\Filament\Resources\LegalOfficeResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditLegalOffice extends XotBaseEditRecord
{
    protected static string $resource = LegalOfficeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
