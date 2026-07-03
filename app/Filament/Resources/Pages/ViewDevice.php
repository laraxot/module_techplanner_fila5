<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\Pages;

use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Modules\TechPlanner\Filament\Resources\DeviceResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Override;

class ViewDevice extends XotBaseViewRecord
{
    protected static string $resource = DeviceResource::class;

    /**
     * {@inheritDoc}
     *
     * @return array<string, Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            'edit' => EditAction::make(),
        ];
    }

    /**
     * {@inheritDoc}
     *
     * @return array<string, Component>
     */
    #[Override]
    protected function getInfolistSchema(): array
    {
        return [
            'base_info' => Section::make(trans('tech_planner::device.sections.base_info.label'))
                ->schema([
                    Grid::make(2)->schema([
                        TextEntry::make('name'),
                        TextEntry::make('serial_number'),
                        TextEntry::make('model'),
                        TextEntry::make('manufacturer'),
                        TextEntry::make('type'),
                        TextEntry::make('status'),
                    ]),
                ])
                ->collapsible(),
            'additional_details' => Section::make(trans('tech_planner::device.sections.additional_details.label'))
                ->schema([
                    TextEntry::make('description')->columnSpan(2),
                    TextEntry::make('purchase_date')->date(),
                    TextEntry::make('warranty_expiry')->date(),
                    TextEntry::make('created_at')->dateTime(),
                    TextEntry::make('updated_at')->dateTime(),
                ])
                ->collapsible(),
        ];
    }
}
