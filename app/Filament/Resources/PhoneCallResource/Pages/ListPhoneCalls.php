<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\PhoneCallResource\Pages;

use Modules\TechPlanner\Filament\Resources\PhoneCallResource;
use Modules\TechPlanner\Filament\Resources\PhoneCallResource\Tables\PhoneCallsTable;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListPhoneCalls extends XotBaseListRecords
{
    protected static string $resource = PhoneCallResource::class;

    public function getTableColumns(): array
    {
        return (new PhoneCallsTable())->getTableColumns();
    }
}
