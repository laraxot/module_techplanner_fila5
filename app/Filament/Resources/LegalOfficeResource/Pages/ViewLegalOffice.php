<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Pages;

use Modules\TechPlanner\Filament\Resources\LegalOfficeResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
<<<<<<< HEAD
use Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Schemas\LegalOfficeInfolist;
=======
>>>>>>> laraxot/dev

class ViewLegalOffice extends XotBaseViewRecord
{
    protected static string $resource = LegalOfficeResource::class;
<<<<<<< HEAD

    /**
     * @return array<string, \Filament\Schemas\Components\Component>
     */
    #[\Override]
    protected function getInfolistSchema(): array
    {
        return app(LegalOfficeInfolist::class)->getInfolistSchema();
    }
=======
>>>>>>> laraxot/dev
}
