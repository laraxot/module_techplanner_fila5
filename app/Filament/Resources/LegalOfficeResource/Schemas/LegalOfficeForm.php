<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class LegalOfficeForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')->required()->maxLength(255),
            'address' => TextInput::make('address')->maxLength(255),
            'city' => TextInput::make('city')->maxLength(255),
            'postal_code' => TextInput::make('postal_code')->maxLength(10),
            'province' => TextInput::make('province')->maxLength(100),
            'phone' => TextInput::make('phone')->tel()->maxLength(255),
            'email' => TextInput::make('email')->email()->maxLength(255),
            'notes' => Textarea::make('notes')->maxLength(65535)->columnSpanFull(),
        ];
    }
}
