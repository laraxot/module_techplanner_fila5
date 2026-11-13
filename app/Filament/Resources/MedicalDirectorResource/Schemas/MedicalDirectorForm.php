<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\MedicalDirectorResource\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Component;
use Modules\TechPlanner\Rules\ItalianFiscalCodeRule;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

/**
 * Un solo modulo per il direttore sanitario, usato dal menu e dalla scheda del cliente (2026-11-10).
 * Prima dal menu mancava il cliente (obbligatorio) e dalla scheda si chiedevano colonne inesistenti.
 */
class MedicalDirectorForm extends XotBaseResourceForm
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
            'fiscal_code' => TextInput::make('fiscal_code')->maxLength(16)->rule(new ItalianFiscalCodeRule()),
            'phone' => TextInput::make('phone')->tel()->maxLength(255),
            'email' => TextInput::make('email')->email()->maxLength(255),
            'license_number' => TextInput::make('license_number')->maxLength(255),
            'specialization' => TextInput::make('specialization')->maxLength(255),
            'license_expiry' => DatePicker::make('license_expiry'),
            'start_date' => DatePicker::make('start_date'),
            'end_date' => DatePicker::make('end_date')->afterOrEqual('start_date'),
            'notes' => Textarea::make('notes')->maxLength(65535)->columnSpanFull(),
        ];
    }
}
