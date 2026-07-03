<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\LegalRepresentativeResource\Pages;

use Modules\TechPlanner\Filament\Resources\LegalRepresentativeResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateLegalRepresentative extends XotBaseCreateRecord
{
    protected static string $resource = LegalRepresentativeResource::class;
}
