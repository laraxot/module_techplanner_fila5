<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ControlResource\Tables;

use Filament\Forms\Components\Select;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Modules\TechPlanner\Enums\ControlTypeEnum;
use Modules\TechPlanner\Filament\Resources\Tables\TechPlannerBaseTable;

class ControlsTable extends TechPlannerBaseTable
{
    /**
     * @return array<int|string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'client.company_name' => TextColumn::make('client.company_name')
                ->label('Client')
                ->placeholder('—')
                ->sortable()
                ->searchable(),
            'control_type' => TextColumn::make('control_type')
                ->badge()
                ->formatStateUsing(fn (ControlTypeEnum|string|null $state): string => $state instanceof ControlTypeEnum ? $state->getLabel() : (string) ($state ?? '—'))
                ->color(fn (ControlTypeEnum|string|null $state): string => $state instanceof ControlTypeEnum ? $state->getColor() : 'gray')
                ->icon(fn (ControlTypeEnum|string|null $state): ?string => $state instanceof ControlTypeEnum ? $state->getIcon() : null)
                ->sortable(),
            'device.name' => TextColumn::make('device.name')->placeholder('—')->toggleable(),
            'control_date' => TextColumn::make('control_date')->date('d/m/Y')->sortable(),
            'next_control_date' => TextColumn::make('next_control_date')->date('d/m/Y')->sortable(),
            'status' => TextColumn::make('status')->badge()->toggleable(),
            'result' => TextColumn::make('result')->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    /**
     * @return array<int|string, BaseFilter>
     */
    public function getTableFilters(): array
    {
        return [
            'control_type' => SelectFilter::make('control_type')
                ->options(ControlTypeEnum::class),
            'client_id' => SelectFilter::make('client_id')
                ->relationship('client', 'company_name')
                ->searchable()
                ->preload(),
            'schedule_status' => Filter::make('schedule_status')
                ->label(__('techplanner::control.filters.schedule_status.label'))
                ->schema([
                    Select::make('value')
                        ->label(__('techplanner::control.filters.schedule_status.value'))
                        ->options([
                            'expired' => __('techplanner::control.filters.expired.label'),
                            'expiring' => __('techplanner::control.filters.expiring.label'),
                            'unscheduled' => __('techplanner::control.widget.unplanned'),
                        ])
                        ->native(false),
                ])
                ->query(static function (Builder $query, array $data): Builder {
                    $value = $data['value'] ?? null;
                    $today = now()->toDateString();
                    $horizon = now()->addDays(30)->toDateString();

                    return match ($value) {
                        'expired' => $query->whereDate('next_control_date', '<', $today),
                        'expiring' => $query
                            ->whereDate('next_control_date', '>=', $today)
                            ->whereDate('next_control_date', '<=', $horizon),
                        'unscheduled' => $query->whereNull('next_control_date'),
                        default => $query,
                    };
                }),
            ...parent::getTableFilters(),
        ];
    }
}
