<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\MedicalDirectorResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\TechPlanner\Filament\Resources\MedicalDirectorResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditMedicalDirector extends XotBaseEditRecord
{
    protected static string $resource = MedicalDirectorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
