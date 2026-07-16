<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ClientResource\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Geo\Filament\Forms\Components\AddressSection;
use Modules\Notify\Filament\Forms\Components\ContactSection;
use Modules\TechPlanner\Filament\Forms\Components\CompanySection;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class ClientForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'company' => CompanySection::make('company'),
            'address' => AddressSection::make('address'),
            'contacts' => ContactSection::make('contacts'),
            'competent_health_unit' => TextInput::make('competent_health_unit'),
            'notes' => Textarea::make('notes'),
        ];
    }
}
