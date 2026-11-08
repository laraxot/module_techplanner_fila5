<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\MedicalDirectorResource\Pages;

use Filament\Schemas\Components\Component;
use Modules\TechPlanner\Filament\Resources\MedicalDirectorResource;
use Modules\TechPlanner\Filament\Resources\MedicalDirectorResource\Schemas\MedicalDirectorInfolist;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewMedicalDirector extends XotBaseViewRecord
{
    protected static string $resource = MedicalDirectorResource::class;

    /**
     * @return array<string, Component>
     */
    protected function getInfolistSchema(): array
    {
        return app(MedicalDirectorInfolist::class)->getInfolistSchema();
    }
}
