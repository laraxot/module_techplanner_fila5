<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\DeviceResource\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class DeviceForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            'client_id' => Select::make('client_id')
                ->relationship('client', 'company_name')
                ->searchable()
                ->preload(),
            'type' => TextInput::make('type')->maxLength(255),
            'brand' => TextInput::make('brand')->maxLength(255),
            // Matricole e modello non sono nome/indirizzo: niente suggerimenti di autofill del browser sopra il campo.
            'model' => TextInput::make('model')->maxLength(255)->autocomplete(false),
            'headset_serial' => TextInput::make('headset_serial')->maxLength(255)->autocomplete(false),
            'tube_serial' => TextInput::make('tube_serial')->maxLength(255)->autocomplete(false),
            'kv' => TextInput::make('kv')->numeric(),
            'ma' => TextInput::make('ma')->numeric(),
            'first_verification_date' => DatePicker::make('first_verification_date'),
            'notes' => Textarea::make('notes')->maxLength(65535)->columnSpanFull(),
        ];
    }
}
