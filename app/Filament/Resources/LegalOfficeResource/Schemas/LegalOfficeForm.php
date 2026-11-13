<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

/**
 * Campi allineati alla tabella `legal_offices` (2026-11-10): mancava il cliente (obbligatorio) e c'era una
 * «nazione» senza colonna.
 */
class LegalOfficeForm extends XotBaseResourceForm
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
                // Dalla scheda del cliente il cliente è già quello: il campo non serve.
                ->hidden(static fn (mixed $livewire): bool => $livewire instanceof RelationManager),
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
