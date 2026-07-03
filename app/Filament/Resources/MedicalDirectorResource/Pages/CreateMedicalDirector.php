<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\MedicalDirectorResource\Pages;

use Modules\TechPlanner\Filament\Resources\MedicalDirectorResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateMedicalDirector extends XotBaseCreateRecord
{
    protected static string $resource = MedicalDirectorResource::class;
}
