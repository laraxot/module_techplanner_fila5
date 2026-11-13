<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Widgets;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\TechPlanner\Filament\Resources\DeviceResource;
use Modules\TechPlanner\Filament\Resources\DeviceResource\Tables\DevicesTable;
use Modules\TechPlanner\Models\Device;
use Modules\Xot\Filament\Widgets\XotBaseTableWidget;

/**
 * FUN-01/FUN-03: gli apparecchi da verificare (scaduti ed entro 30 giorni), dal più urgente.
 * Clic sulla riga: scheda dell'apparecchio, dove si registra la verifica.
 */
class DueDevicesWidget extends XotBaseTableWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    public function getModel(): string
    {
        return Device::class;
    }

    protected function getTableHeading(): string
    {
        return __('techplanner::dashboard.due_devices.heading', ['days' => DevicesTable::DUE_SOON_DAYS]);
    }

    public function getTableColumns(): array
    {
        return [
            'next_verification_date' => TextColumn::make('next_verification_date')
                ->label(__('techplanner::devices.fields.next_verification_date.label'))
                ->date('d/m/Y')
                ->badge()
                ->color(static fn (?Carbon $state): string => DevicesTable::dueColor($state)),
            'client.company_name' => TextColumn::make('client.company_name')
                ->label(__('techplanner::devices.fields.client.company_name.label'))
                ->searchable(),
            'type' => TextColumn::make('type')->label(__('techplanner::devices.fields.type.label')),
            'brand' => TextColumn::make('brand')->label(__('techplanner::devices.fields.brand.label')),
            'model' => TextColumn::make('model')->label(__('techplanner::devices.fields.model.label'))->visibleFrom('md'),
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
     * @return Builder<Device>
     */
    protected function getTableQuery(): Builder
    {
        return Device::query()
            ->with('client')
            ->withNextVerificationDate()
            ->verificationDueBy(today()->addDays(DevicesTable::DUE_SOON_DAYS))
            ->orderBy('next_verification_date');
    }

    public function getTableRecordUrl(): ?\Closure
    {
        return static fn (Device $record): string => DeviceResource::getUrl('view', ['record' => $record]);
    }
}
