<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\MedicalDirectorResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class MedicalDirectorInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'name' => TextEntry::make('name'),
            'license_number' => TextEntry::make('license_number'),
            'specialization' => TextEntry::make('specialization'),
            'email' => TextEntry::make('email'),
            'phone' => TextEntry::make('phone'),
            'license_expiry' => TextEntry::make('license_expiry')->date(),
            'notes' => TextEntry::make('notes'),
        ];
    }
}
