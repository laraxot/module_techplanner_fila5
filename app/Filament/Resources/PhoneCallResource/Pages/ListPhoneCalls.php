<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\PhoneCallResource\Pages;

use Filament\Tables\Columns\TextColumn;
use Modules\TechPlanner\Filament\Resources\PhoneCallResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListPhoneCalls extends XotBaseListRecords
{
    protected static string $resource = PhoneCallResource::class;

    public function getTableColumns(): array
    {
        return [
            TextColumn::make('date')->sortable(),
            TextColumn::make('duration')->sortable(),
            TextColumn::make('notes')->limit(50),
            TextColumn::make('call_type')->sortable(),
        ];
    }
}
