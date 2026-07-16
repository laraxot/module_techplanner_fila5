<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\PhoneCallResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class PhoneCallsTable extends XotBaseResourceTable
{
    /**
     * @return array<int|string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'date' => TextColumn::make('date')->sortable(),
            'duration' => TextColumn::make('duration')->sortable(),
            'notes' => TextColumn::make('notes')->limit(50),
            'call_type' => TextColumn::make('call_type')->sortable(),
        ];
    }
}
