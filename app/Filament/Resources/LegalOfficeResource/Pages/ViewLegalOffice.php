<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Pages;

use Modules\TechPlanner\Filament\Resources\LegalOfficeResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Schemas\LegalOfficeInfolist;

class ViewLegalOffice extends XotBaseViewRecord
{
    protected static string $resource = LegalOfficeResource::class;

    /**
     * @return array<string, \Filament\Schemas\Components\Component>
     */
    protected function getInfolistSchema(): array
    {
        return app(LegalOfficeInfolist::class)->getInfolistSchema();
    }
}
