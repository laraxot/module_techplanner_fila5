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
    public function getInfolistSchema(): array
    {
        return [
            'client.company_name' => TextEntry::make('client.company_name'),
            'name' => TextEntry::make('name'),
            'fiscal_code' => TextEntry::make('fiscal_code'),
            'phone' => TextEntry::make('phone'),
            'email' => TextEntry::make('email'),
            'notes' => TextEntry::make('notes'),
        ];
    }
}
