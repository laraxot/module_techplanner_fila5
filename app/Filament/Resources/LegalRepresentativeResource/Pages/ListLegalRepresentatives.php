<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\LegalRepresentativeResource\Pages;

use Filament\Actions\CreateAction;
use Modules\TechPlanner\Filament\Resources\LegalRepresentativeResource;
use Modules\TechPlanner\Filament\Resources\LegalRepresentativeResource\Tables\LegalRepresentativesTable;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListLegalRepresentatives extends XotBaseListRecords
{
    protected static string $resource = LegalRepresentativeResource::class;

    public function getTableColumns(): array
    {
        return (new LegalRepresentativesTable())->getTableColumns();
    }

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            'create' => CreateAction::make(),
        ];
    }
}
