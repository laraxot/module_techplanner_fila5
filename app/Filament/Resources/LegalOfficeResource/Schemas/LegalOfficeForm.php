<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class LegalOfficeForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')->required()->maxLength(255),
            'address' => TextInput::make('address')->required()->maxLength(255),
            'city' => TextInput::make('city')->required()->maxLength(255),
            'postal_code' => TextInput::make('postal_code')->required()->maxLength(10),
            'province' => TextInput::make('province')->required()->maxLength(2),
            'country' => TextInput::make('country')
                ->required()
                ->default('IT')
                ->maxLength(2),
            'phone' => TextInput::make('phone')->tel()->maxLength(255),
            'email' => TextInput::make('email')->email()->maxLength(255),
        ];
    }
}
