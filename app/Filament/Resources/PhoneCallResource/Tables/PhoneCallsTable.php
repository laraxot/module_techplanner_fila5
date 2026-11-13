<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\PhoneCallResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\TechPlanner\Filament\Resources\Tables\TechPlannerBaseTable;

class PhoneCallsTable extends TechPlannerBaseTable
{
    /**
     * @return array<int|string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'client.company_name' => TextColumn::make('client.company_name')->searchable()->sortable(),
            'date' => TextColumn::make('date')->dateTime('d/m/Y H:i')->sortable(),
            'duration' => TextColumn::make('duration')->sortable(),
            'notes' => TextColumn::make('notes')->limit(50),
            'call_type' => TextColumn::make('call_type')->sortable(),
        ];
    }
}
