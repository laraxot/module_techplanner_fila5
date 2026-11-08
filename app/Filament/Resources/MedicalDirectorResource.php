<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources;

use Modules\TechPlanner\Models\MedicalDirector;
use Modules\Xot\Filament\Resources\XotBaseResource;

class MedicalDirectorResource extends XotBaseResource
{
    protected static ?string $model = MedicalDirector::class;
}
