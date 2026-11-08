<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ClientResource\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\View;
use Illuminate\Database\Eloquent\Model;
use Modules\Geo\Filament\Forms\Components\AddressSection;
use Modules\Notify\Filament\Forms\Components\ContactSection;
use Modules\TechPlanner\Filament\Forms\Components\ClientCoordinatesSection;
use Modules\TechPlanner\Filament\Forms\Components\CompanySection;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class ClientForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            'company' => CompanySection::make('company'),
            'address' => AddressSection::make('address')
                ->extraComponents([
                    ClientCoordinatesSection::make()
                        ->heading(__('techplanner::client.sections.coordinates.label'))
                        ->description(__('techplanner::client.sections.coordinates.description')),
                    View::make('techplanner::filament.forms.client-location-map')
                        ->viewData(static fn (?Model $record): array => [
                            'client' => $record,
                            'asset_base' => asset('assets/geo/assets'),
                        ])
                        ->columnSpanFull(),
                ]),
            'contacts' => ContactSection::make('contacts'),
            'competent_health_unit' => TextInput::make('competent_health_unit'),
            'notes' => Textarea::make('notes'),
        ];
    }
}
