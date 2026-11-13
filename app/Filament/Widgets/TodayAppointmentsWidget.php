<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Widgets;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Modules\TechPlanner\Models\Appointment;
use Modules\Xot\Filament\Widgets\XotBaseTableWidget;

/**
 * FUN-03: il giro di oggi, in ordine di orario, con le note per il tecnico.
 */
class TodayAppointmentsWidget extends XotBaseTableWidget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    public function getModel(): string
    {
        return Appointment::class;
    }

    protected function getTableHeading(): string
    {
        return __('techplanner::dashboard.today_appointments.heading');
    }

    public function getTableColumns(): array
    {
        return [
            'date' => TextColumn::make('date')
                ->label(__('techplanner::dashboard.today_appointments.columns.time'))
                ->dateTime('H:i'),
            'client.company_name' => TextColumn::make('client.company_name')
                ->label(__('techplanner::appointments.fields.client.company_name.label')),
            'notes' => TextColumn::make('notes')
                ->label(__('techplanner::appointments.fields.notes.label'))
                ->wrap(),
        ];
    }

    /**
     * @return array<string, Action|ActionGroup>
     */
    public function getTableActions(): array
    {
        return [];
    }

    /**
     * @return array<string, Action>
     */
    public function getTableBulkActions(): array
    {
        return [];
    }

    /**
     * @return array<string, Action>
     */
    public function getTableHeaderActions(): array
    {
        return [];
    }

    /**
     * @return Builder<Appointment>
     */
    protected function getTableQuery(): Builder
    {
        return Appointment::query()->with('client')->whereDate('date', today())->orderBy('date');
    }
}
