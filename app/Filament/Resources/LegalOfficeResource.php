<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources;

use Modules\TechPlanner\Models\LegalOffice;
use Modules\Xot\Filament\Resources\XotBaseResource;

class LegalOfficeResource extends XotBaseResource
{
    protected static ?string $model = LegalOffice::class;
}
