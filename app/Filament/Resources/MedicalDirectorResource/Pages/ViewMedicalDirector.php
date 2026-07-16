<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\MedicalDirectorResource\Pages;

use Modules\TechPlanner\Filament\Resources\MedicalDirectorResource;
use Modules\TechPlanner\Filament\Resources\MedicalDirectorResource\Schemas\MedicalDirectorInfolist;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Override;

class ViewMedicalDirector extends XotBaseViewRecord
{
    protected static string $resource = MedicalDirectorResource::class;

    #[Override]
    protected function getInfolistSchema(): array
    {
        return MedicalDirectorInfolist::getInfolistSchema();
    }
}
