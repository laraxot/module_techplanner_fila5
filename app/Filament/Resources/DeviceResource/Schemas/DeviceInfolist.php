<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\DeviceResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class DeviceInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'device_information' => Section::make('Device Information')->schema([
                TextEntry::make('client.company_name')->label('Client'),
                TextEntry::make('type')->label('Type'),
                TextEntry::make('brand')->label('Brand'),
                TextEntry::make('model')->label('Model'),
                TextEntry::make('headset_serial')->label('Headset Serial'),
                TextEntry::make('tube_serial')->label('Tube Serial'),
                TextEntry::make('kv')->label('kV'),
                TextEntry::make('ma')->label('mA'),
            ]),
            'dates' => Section::make('Dates')->schema([
                TextEntry::make('first_verification_date')->label('First Verification Date')->date(),
            ]),
            'additional_information' => Section::make('Additional Information')->schema([
                TextEntry::make('notes')->label('Notes')->markdown(),
            ]),
        ];
    }
}
