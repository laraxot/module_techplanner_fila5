<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Pages;

use Filament\Actions\CreateAction;
use Modules\TechPlanner\Filament\Resources\LegalOfficeResource;
use Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Tables\LegalOfficesTable;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListLegalOffices extends XotBaseListRecords
{
    protected static string $resource = LegalOfficeResource::class;

    public function getTableColumns(): array
    {
        return (new LegalOfficesTable())->getTableColumns();
    }

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            'create' => CreateAction::make(),
        ];
    }
}
