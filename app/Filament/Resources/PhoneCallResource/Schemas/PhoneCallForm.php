<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\PhoneCallResource\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\TechPlanner\Enums\PhoneCallEnum;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class PhoneCallForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'date' => DateTimePicker::make('date'),
            'duration' => TextInput::make('duration'),
            'notes' => Textarea::make('notes'),
            'call_type' => Select::make('call_type')->options(PhoneCallEnum::class),
        ];
    }
}
