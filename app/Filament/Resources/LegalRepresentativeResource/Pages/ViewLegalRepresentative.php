<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\LegalRepresentativeResource\Pages;

use Modules\TechPlanner\Filament\Resources\LegalRepresentativeResource;
use Modules\TechPlanner\Filament\Resources\LegalRepresentativeResource\Schemas\LegalRepresentativeInfolist;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Override;

class ViewLegalRepresentative extends XotBaseViewRecord
{
    protected static string $resource = LegalRepresentativeResource::class;

    #[Override]
    protected function getInfolistSchema(): array
    {
        return LegalRepresentativeInfolist::getInfolistSchema();
    }
}
