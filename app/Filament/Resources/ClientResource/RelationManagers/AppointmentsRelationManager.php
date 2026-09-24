<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ClientResource\RelationManagers;

use Filament\Tables\Columns;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\TechPlanner\Filament\Resources\AppointmentResource;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;
use Override;

class AppointmentsRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'appointments';

    protected static string $resource = AppointmentResource::class;

    /**
     * Get table columns for the relation manager.
     *
     * @return array<string, Column>
     */
    #[Override]
    public function getTableColumns(): array
    {
        return [
            'date' => TextColumn::make('date')->sortable(),
            'notes' => TextColumn::make('notes')->limit(50),
            /*
             * 'machines_count' => Columns\TextColumn::make('machines_count')
             * ->label('Machines Checked')
             * ->counts('machines'),
             */
        ];
    }

    public function canAttach(): bool
    {
        return false;
    }

    public function canCreate(): bool
    {
        return true;
    }
}
