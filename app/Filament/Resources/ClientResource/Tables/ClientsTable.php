<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ClientResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Geo\Filament\Tables\Columns\AddressColumn;
use Modules\Notify\Filament\Tables\Columns\ContactColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class ClientsTable extends XotBaseResourceTable
{
    /**
     * @return array<int|string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'distance' => TextColumn::make('distance')->formatStateUsing(function (string|int|float|null $state): string {
                $distance = is_numeric($state) ? (float) $state : 0.0;

                return number_format($distance, 2).' km';
            }),
            'longitude' => TextColumn::make('longitude')->sortable()->toggleable(isToggledHiddenByDefault: true),
            'latitude' => TextColumn::make('latitude')->sortable()->toggleable(isToggledHiddenByDefault: true),
            'business_closed' => TextColumn::make('business_closed')->toggleable(isToggledHiddenByDefault: true),
            'activity' => TextColumn::make('activity')
                ->searchable()
                ->sortable()
                ->wrap(),
            'company_name' => TextColumn::make('company_name')
                ->searchable()
                ->sortable()
                ->wrap(),
            'fiscal_code' => TextColumn::make('fiscal_code')->toggleable(isToggledHiddenByDefault: true),
            /*
            'full_address' => TextColumn::make('full_address')
                ->searchable(['city', 'company_office', 'postal_code', 'province', 'country', 'address'])
                ->sortable()
                ->wrap(),

            'city' => TextColumn::make('city')->toggleable(isToggledHiddenByDefault: true),
            'province' => TextColumn::make('province')->toggleable(isToggledHiddenByDefault: true),
            'country' => TextColumn::make('country')->toggleable(isToggledHiddenByDefault: true),
            'updated_at' => TextColumn::make('updated_at')->toggleable(isToggledHiddenByDefault: true)->sortable(),
            'created_at' => TextColumn::make('created_at')->toggleable(isToggledHiddenByDefault: true)->sortable(),

            */
            'address' => AddressColumn::make('address'),
            'contacts' => ContactColumn::make('contacts'),
        ];
    }
}
