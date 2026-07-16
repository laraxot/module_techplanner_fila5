<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Pages;

use Modules\TechPlanner\Filament\Resources\LegalOfficeResource;
use Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Schemas\LegalOfficeInfolist;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Override;

class ViewLegalOffice extends XotBaseViewRecord
{
    protected static string $resource = LegalOfficeResource::class;

    #[Override]
    protected function getInfolistSchema(): array
    {
        return LegalOfficeInfolist::getInfolistSchema();
    }
}
