<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Modules\Geo\Filament\Forms\Components\AddressSection;
use Modules\Notify\Filament\Forms\Components\ContactSection;
use Modules\TechPlanner\Filament\Forms\Components\CompanySection;
use Modules\TechPlanner\Models\Client;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

/**
 * @property ClientResource $resource
 */
class ClientResource extends XotBaseResource
{
    protected static ?string $model = Client::class;

    #[Override]
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
