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
    public function getInfolistSchema(): array
    {
        return [
            'device_information' => Section::make('device_information')->schema([
                TextEntry::make('client.company_name'),
                TextEntry::make('type'),
                TextEntry::make('brand'),
                TextEntry::make('model'),
                TextEntry::make('headset_serial'),
                TextEntry::make('tube_serial'),
                TextEntry::make('kv'),
                TextEntry::make('ma'),
            ]),
            'dates' => Section::make('dates')->schema([
                TextEntry::make('first_verification_date')->date(),
            ]),
            'additional_information' => Section::make('additional_information')->schema([
                TextEntry::make('notes')->markdown(),
            ]),
        ];
    }
}
