<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\MedicalDirectorResource\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class MedicalDirectorForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')->required()->maxLength(255),
            'fiscal_code' => TextInput::make('fiscal_code')->maxLength(16),
            'email' => TextInput::make('email')
                ->email()
                ->maxLength(255),
            'phone' => TextInput::make('phone')
                ->tel()
                ->maxLength(255),
            'notes' => Textarea::make('notes')->maxLength(65535)->columnSpanFull(),
        ];
    }
}
