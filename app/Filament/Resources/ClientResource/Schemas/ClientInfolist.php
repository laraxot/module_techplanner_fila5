<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ClientResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class ClientInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'company' => Section::make(trans('tech_planner::client.sections.company.label'))->schema([
                TextEntry::make('company_name'),
                TextEntry::make('activity'),
                TextEntry::make('business_closed'),
                TextEntry::make('tax_code'),
                TextEntry::make('vat_number'),
                TextEntry::make('fiscal_code'),
            ]),
            'contact_info' => Section::make(trans('tech_planner::client.sections.contact_info.label'))->schema([
                TextEntry::make('address'),
                TextEntry::make('street_number'),
                TextEntry::make('city'),
                TextEntry::make('postal_code'),
                TextEntry::make('province'),
                TextEntry::make('country'),
                TextEntry::make('phone'),
                TextEntry::make('mobile'),
                TextEntry::make('fax'),
                TextEntry::make('email'),
            ]),
            'additional_info' => Section::make(trans('tech_planner::client.sections.additional_info.label'))->schema([
                TextEntry::make('competent_health_unit'),
                TextEntry::make('company_office'),
                TextEntry::make('notes'),
            ]),
        ];
    }
}
