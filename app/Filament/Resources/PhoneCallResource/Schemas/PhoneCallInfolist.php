<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\PhoneCallResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class PhoneCallInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'date' => TextEntry::make('date')->dateTime(),
            'duration' => TextEntry::make('duration'),
            'call_type' => TextEntry::make('call_type'),
            'notes' => TextEntry::make('notes'),
        ];
    }
}
