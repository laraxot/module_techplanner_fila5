<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Pages;

use Filament\Schemas\Components\Component;
use Modules\TechPlanner\Filament\Resources\LegalOfficeResource;
use Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Schemas\LegalOfficeInfolist;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewLegalOffice extends XotBaseViewRecord
{
    protected static string $resource = LegalOfficeResource::class;

    /**
     * @return array<string, Component>
     */
    protected function getInfolistSchema(): array
    {
        return app(LegalOfficeInfolist::class)->getInfolistSchema();
    }
}
