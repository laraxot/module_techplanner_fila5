<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources;

use Modules\TechPlanner\Filament\Resources\LegalRepresentativeResource\Pages\CreateLegalRepresentative;
use Modules\TechPlanner\Filament\Resources\LegalRepresentativeResource\Pages\EditLegalRepresentative;
use Modules\TechPlanner\Filament\Resources\LegalRepresentativeResource\Pages\ListLegalRepresentatives;
use Modules\TechPlanner\Filament\Resources\LegalRepresentativeResource\Pages\ViewLegalRepresentative;
use Modules\TechPlanner\Filament\Resources\LegalRepresentativeResource\Schemas\LegalRepresentativeForm;
use Modules\TechPlanner\Filament\Resources\LegalRepresentativeResource\Schemas\LegalRepresentativeInfolist;
use Modules\TechPlanner\Models\LegalRepresentative;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class LegalRepresentativeResource extends XotBaseResource
{
    protected static ?string $model = LegalRepresentative::class;

 
}
