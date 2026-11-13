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
    public function getInfolistSchema(): array
    {
        return [
            'client.company_name' => TextEntry::make('client.company_name'),
            'name' => TextEntry::make('name'),
            'fiscal_code' => TextEntry::make('fiscal_code'),
            'license_number' => TextEntry::make('license_number'),
            'specialization' => TextEntry::make('specialization'),
            'email' => TextEntry::make('email'),
            'phone' => TextEntry::make('phone'),
            'license_expiry' => TextEntry::make('license_expiry')->date('d/m/Y'),
            'start_date' => TextEntry::make('start_date')->date('d/m/Y'),
            'end_date' => TextEntry::make('end_date')->date('d/m/Y')->placeholder('—'),
            'notes' => TextEntry::make('notes'),
        ];
    }
}
