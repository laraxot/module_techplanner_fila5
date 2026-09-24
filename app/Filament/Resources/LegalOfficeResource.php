<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources;

use Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Pages\CreateLegalOffice;
use Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Pages\EditLegalOffice;
use Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Pages\ListLegalOffices;
use Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Pages\ViewLegalOffice;
use Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Schemas\LegalOfficeForm;
use Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Schemas\LegalOfficeInfolist;
use Modules\TechPlanner\Models\LegalOffice;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class LegalOfficeResource extends XotBaseResource
{
    protected static ?string $model = LegalOffice::class;

   
}
