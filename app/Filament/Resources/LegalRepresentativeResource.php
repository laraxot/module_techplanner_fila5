<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources;

use Modules\TechPlanner\Models\LegalRepresentative;
use Modules\Xot\Filament\Resources\XotBaseResource;

class LegalRepresentativeResource extends XotBaseResource
{
    protected static ?string $model = LegalRepresentative::class;
}
