<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\LegalRepresentativeResource\Pages;

use Modules\TechPlanner\Filament\Resources\LegalRepresentativeResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Modules\TechPlanner\Filament\Resources\LegalRepresentativeResource\Schemas\LegalRepresentativeInfolist;

class ViewLegalRepresentative extends XotBaseViewRecord
{
    protected static string $resource = LegalRepresentativeResource::class;

    /**
     * @return array<string, \Filament\Schemas\Components\Component>
     */
    #[\Override]
    protected function getInfolistSchema(): array
    {
        return app(LegalRepresentativeInfolist::class)->getInfolistSchema();
    }
}
