<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\AppointmentResource\Tables;

use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Modules\TechPlanner\Enums\AppointmentStatusEnum;
use Modules\TechPlanner\Filament\Resources\Tables\TechPlannerBaseTable;
use Modules\UI\Filament\Tables\Columns\IDColumn;

class AppointmentsTable extends TechPlannerBaseTable
{
    /**
     * @return array<int|string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            // Telefono: la card ha una riga per colonna. Per aprire un appuntamento servono cliente e quando;
            // id e date di sistema sono nascosti di default (riattivabili dal selettore colonne), le note da `md`.
            'id' => IDColumn::make('id')->toggleable(isToggledHiddenByDefault: true),
            'client.company_name' => TextColumn::make('client.company_name')->searchable()->sortable(),
            'worker.full_name' => TextColumn::make('worker.full_name')->placeholder('—')->toggleable(),
            'date' => TextColumn::make('date')->dateTime('d/m/Y H:i')->sortable(),
            'duration_minutes' => TextColumn::make('duration_minutes')
                ->suffix(' '.__('techplanner::appointment.fields.duration_minutes.suffix'))
                ->placeholder('—')
                ->toggleable(),
            'status' => TextColumn::make('status')
                ->badge()
                ->formatStateUsing(static fn (mixed $state): string => $state instanceof AppointmentStatusEnum ? $state->getLabel() : (is_string($state) ? $state : ''))
                ->color(static fn (mixed $state): string => $state instanceof AppointmentStatusEnum ? $state->getColor() : 'gray'),
            'notes' => TextColumn::make('notes')->limit(50)->visibleFrom('md'),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    /**
     * @return array<int|string, BaseFilter>
     */
    #[\Override]
    public function getTableFilters(): array
    {
        return [
            'status' => SelectFilter::make('status')
                ->options(AppointmentStatusEnum::class),
            'worker_id' => SelectFilter::make('worker_id')
                ->relationship('worker', 'first_name')
                ->searchable()
                ->preload(),
            'date_range' => Filter::make('date_range')
                ->schema([
                    DatePicker::make('from'),
                    DatePicker::make('until'),
                ])
                ->query(static function (Builder $query, array $data): Builder {
                    $from = $data['from'] ?? null;
                    $until = $data['until'] ?? null;

                    if (is_string($from) && $from !== '') {
                        $query->whereDate('date', '>=', $from);
                    }
                    if (is_string($until) && $until !== '') {
                        $query->whereDate('date', '<=', $until);
                    }

                    return $query;
                }),
            ...parent::getTableFilters(),
        ];
    }
}
