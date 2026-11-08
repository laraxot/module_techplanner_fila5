<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\LegalRepresentativeResource\Pages;

use Filament\Schemas\Components\Component;
use Modules\TechPlanner\Filament\Resources\LegalRepresentativeResource;
use Modules\TechPlanner\Filament\Resources\LegalRepresentativeResource\Schemas\LegalRepresentativeInfolist;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewLegalRepresentative extends XotBaseViewRecord
{
    protected static string $resource = LegalRepresentativeResource::class;

    /**
     * @return array<string, Component>
     */
    protected function getInfolistSchema(): array
    {
        return app(LegalRepresentativeInfolist::class)->getInfolistSchema();
    }
}
