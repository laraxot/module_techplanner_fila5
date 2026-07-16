<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\MedicalDirectorResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ImportAction;
use Filament\Tables\Filters\SelectFilter;
use Modules\TechPlanner\Filament\Imports\MedicalDirectorImporter;
use Modules\TechPlanner\Filament\Resources\MedicalDirectorResource;
use Modules\TechPlanner\Filament\Resources\MedicalDirectorResource\Tables\MedicalDirectorsTable;
use Modules\TechPlanner\Models\MedicalDirector;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListMedicalDirectors extends XotBaseListRecords
{
    protected static string $resource = MedicalDirectorResource::class;

    public function getTableColumns(): array
    {
        return (new MedicalDirectorsTable())->getTableColumns();
    }

    public function getTableFilters(): array
    {
        return [
            SelectFilter::make('created_at')->options(
                function () {
                    $dates = MedicalDirector::selectRaw('DATE(created_at) as date')
                        ->distinct()
                        ->pluck('date', 'date');

                    if (is_object($dates) && method_exists($dates, 'toArray')) {
                        return $dates->toArray();
                    }

                    return [];
                },
            ),
        ];
    }

    #[Override]
    protected function getHeaderActions(): array
    {
        /** @var array<string, Action> $actions */
        $actions = [
            ...parent::getHeaderActions(),
            ImportAction::make('importMedicalDirector')->importer(MedicalDirectorImporter::class),
        ];

        return $actions;
    }
}
