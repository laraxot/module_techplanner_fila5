<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\PhoneCallResource\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Component;
use Modules\TechPlanner\Enums\PhoneCallEnum;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class PhoneCallForm extends XotBaseResourceForm
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
                ->preload()
                ->required()
                ->hidden(static fn (mixed $livewire): bool => $livewire instanceof RelationManager),
            'date' => DateTimePicker::make('date'),
            // Secondi (colonna integer): tastierino numerico su telefono e niente "3 min" che romperebbe il salvataggio.
            'duration' => TextInput::make('duration')->integer()->minValue(0),
            'notes' => Textarea::make('notes'),
            'call_type' => Select::make('call_type')->options(PhoneCallEnum::class),
        ];
    }
}
