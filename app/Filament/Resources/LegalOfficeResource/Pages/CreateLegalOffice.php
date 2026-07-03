<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Pages;

use Modules\TechPlanner\Filament\Resources\LegalOfficeResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateLegalOffice extends XotBaseCreateRecord
{
    protected static string $resource = LegalOfficeResource::class;
}
