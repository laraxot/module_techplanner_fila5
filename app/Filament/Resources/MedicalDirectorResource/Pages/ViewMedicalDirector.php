<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\MedicalDirectorResource\Pages;

use Modules\TechPlanner\Filament\Resources\MedicalDirectorResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewMedicalDirector extends XotBaseViewRecord
{
    protected static string $resource = MedicalDirectorResource::class;
}
