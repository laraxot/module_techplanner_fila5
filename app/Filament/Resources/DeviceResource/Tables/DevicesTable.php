<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\DeviceResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\TechPlanner\Filament\Resources\Tables\TechPlannerBaseTable;
use Modules\TechPlanner\Models\Device;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Override;

class DevicesTable extends TechPlannerBaseTable
{
    /** Giorni entro cui una verifica è «in scadenza» (giallo). */
    public const int DUE_SOON_DAYS = 30;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            // Telefono: la card ha una riga per colonna. Il tecnico cerca "di chi e' e che apparecchio e'":
            // il cliente va per nome (prima era il numero grezzo del client_id), id/kv/mA/note da `md`.
            'id' => IDColumn::make('id')->toggleable(isToggledHiddenByDefault: true),
            'client.company_name' => TextColumn::make('client.company_name')
                ->label(__('techplanner::device.fields.client_id.label'))
                ->sortable()
                ->searchable(),
            // FUN-01: quando tornare, dall'ultima verifica. Rosso = scaduta, giallo = entro 30 giorni.
            'next_verification_date' => TextColumn::make('next_verification_date')
                ->date('d/m/Y')
                ->placeholder('—')
                ->badge()
                ->color(static fn (?Carbon $state): string => self::dueColor($state))
                ->sortable(),
            'type' => TextColumn::make('type')->sortable()->searchable(),
            'brand' => TextColumn::make('brand')->sortable()->searchable(),
            'model' => TextColumn::make('model')->sortable()->searchable(),
            'headset_serial' => TextColumn::make('headset_serial')->sortable()->searchable(),
            'tube_serial' => TextColumn::make('tube_serial')->sortable()->searchable(),
            'kv' => TextColumn::make('kv')->sortable()->searchable()->visibleFrom('md'),
            'ma' => TextColumn::make('ma')->sortable()->searchable()->visibleFrom('md'),
            'first_verification_date' => TextColumn::make('first_verification_date')
                ->date('d/m/Y')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'controls_count' => TextColumn::make('controls_count')
                ->counts('controls')
                ->sortable()
                ->toggleable(),
            'notes' => TextColumn::make('notes')->sortable()->searchable()->wrap()->visibleFrom('md'),
        ];
    }

    #[Override]
    public function table(Table $table): Table
    {
        return parent::table($table)->modifyQueryUsing(static function (Builder $query): Builder {
            $query->scopes('withNextVerificationDate');

            return $query;
        });
    }

    /**
     * @return array<string|int, BaseFilter>
     */
    #[Override]
    public function getTableFilters(): array
    {
        return [
            'due' => SelectFilter::make('due')
                ->options([
                    'overdue' => __('techplanner::devices.filters.due.options.overdue'),
                    '30' => __('techplanner::devices.filters.due.options.30'),
                    '60' => __('techplanner::devices.filters.due.options.60'),
                    '90' => __('techplanner::devices.filters.due.options.90'),
                    'never' => __('techplanner::devices.filters.due.options.never'),
                ])
                ->query(static function (Builder $query, array $data): Builder {
                    /** @var Builder<Device> $query */
                    return match ($data['value'] ?? null) {
                        'overdue' => $query->verificationDueBy(now()->subDay()),
                        '30', '60', '90' => $query->verificationDueBy(now()->addDays((int) $data['value'])),
                        'never' => $query->neverVerified(),
                        default => $query,
                    };
                }),
            ...parent::getTableFilters(),
        ];
    }

    public static function dueColor(?Carbon $date): string
    {
        return match (true) {
            $date === null => 'gray',
            $date->isBefore(today()) => 'danger',
            $date->lte(today()->addDays(self::DUE_SOON_DAYS)) => 'warning',
            default => 'success',
        };
    }
}
