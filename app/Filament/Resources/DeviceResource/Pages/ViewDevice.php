<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\DeviceResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Modules\TechPlanner\Filament\Resources\DeviceResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Override;

class ViewDevice extends XotBaseViewRecord
{
    protected static string $resource = DeviceResource::class;

    /**
     * @return array<string, Section>
     */
    #[Override]
    protected function getInfolistSchema(): array
    {
        return [
            'device_information' => Section::make('Device Information')->schema([
                TextEntry::make('name')->label('Name'),
                TextEntry::make('serial_number')->label('Serial Number'),
                TextEntry::make('model')->label('Model'),
                TextEntry::make('manufacturer')->label('Manufacturer'),
            ]),
            'dates' => Section::make('Dates')->schema([
                TextEntry::make('purchase_date')->label('Purchase Date')->date(),
                TextEntry::make('warranty_expiration')->label('Warranty Expiration')->date(),
            ]),
            'additional_information' => Section::make('Additional Information')->schema([
                TextEntry::make('notes')->label('Notes')->markdown(),
            ]),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            'edit' => EditAction::make(),
            'delete' => DeleteAction::make(),
        ];
    }
}
