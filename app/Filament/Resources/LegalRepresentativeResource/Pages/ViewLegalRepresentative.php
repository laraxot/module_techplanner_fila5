<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\LegalRepresentativeResource\Pages;

use Modules\TechPlanner\Filament\Resources\LegalRepresentativeResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
<<<<<<< HEAD
use Modules\TechPlanner\Filament\Resources\LegalRepresentativeResource\Schemas\LegalRepresentativeInfolist;
=======
>>>>>>> laraxot/dev

class ViewLegalRepresentative extends XotBaseViewRecord
{
    protected static string $resource = LegalRepresentativeResource::class;
<<<<<<< HEAD

    /**
     * @return array<string, \Filament\Schemas\Components\Component>
     */
    #[\Override]
    protected function getInfolistSchema(): array
    {
        return app(LegalRepresentativeInfolist::class)->getInfolistSchema();
    }
=======
>>>>>>> laraxot/dev
}
