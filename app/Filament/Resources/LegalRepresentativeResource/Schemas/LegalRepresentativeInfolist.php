<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\LegalRepresentativeResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class LegalRepresentativeInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'name' => TextEntry::make('name'),
            'surname' => TextEntry::make('surname'),
            'email' => TextEntry::make('email'),
            'phone' => TextEntry::make('phone'),
            'tax_code' => TextEntry::make('tax_code'),
            'role' => TextEntry::make('role'),
        ];
    }
}
