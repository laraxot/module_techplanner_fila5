<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\MedicalDirectorResource\Pages;

use Modules\TechPlanner\Filament\Resources\MedicalDirectorResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Modules\TechPlanner\Filament\Resources\MedicalDirectorResource\Schemas\MedicalDirectorInfolist;

class ViewMedicalDirector extends XotBaseViewRecord
{
    protected static string $resource = MedicalDirectorResource::class;

    /**
     * @return array<string, \Filament\Schemas\Components\Component>
     */
    #[\Override]
    protected function getInfolistSchema(): array
    {
        return app(MedicalDirectorInfolist::class)->getInfolistSchema();
    }
}
