<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\MedicalDirectorResource\Pages;

use Modules\TechPlanner\Filament\Resources\MedicalDirectorResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
<<<<<<< HEAD
use Modules\TechPlanner\Filament\Resources\MedicalDirectorResource\Schemas\MedicalDirectorInfolist;
=======
>>>>>>> laraxot/dev

class ViewMedicalDirector extends XotBaseViewRecord
{
    protected static string $resource = MedicalDirectorResource::class;
<<<<<<< HEAD

    /**
     * @return array<string, \Filament\Schemas\Components\Component>
     */
    #[\Override]
    protected function getInfolistSchema(): array
    {
        return app(MedicalDirectorInfolist::class)->getInfolistSchema();
    }
=======
>>>>>>> laraxot/dev
}
